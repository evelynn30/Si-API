<?php

namespace App\Http\Controllers;

use App\Models\Temuan;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTemuanRequest;
use App\Http\Requests\UpdateTemuanRequest;
use App\Models\Penemu;
use App\Models\Insiden;
use App\Models\Opd;
use App\Models\TemuanInsiden;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TemuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $temuan = Temuan::with(['penemu', 'opd', 'suratKeluarTemuan', 'temuanInsiden.insiden'])
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('opd', function ($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%");
                })->orWhereHas('penemu', function ($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%");
                });
            })
            ->when($status !== null, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(5);

        // Count for each status
        $allCount = Temuan::count();
        $baruCount = Temuan::where('status', 0)->count();
        $menungguCount = Temuan::where('status', 1)->count();
        $penangananCount = Temuan::where('status', 2)->count();
        $selesaiCount = Temuan::where('status', 3)->count();

        return view('pages.dashboard.main-menu.temuan.index', compact('temuan', 'search', 'status', 'allCount', 'baruCount', 'menungguCount', 'penangananCount', 'selesaiCount'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $penemu = Penemu::active()->orderBy('nama', 'asc')->pluck('nama', 'id');
        $insiden = Insiden::active()->orderBy('nama', 'asc')->pluck('nama', 'id');
        $opd = Opd::active()->orderBy('nama', 'asc')->pluck('nama', 'id');
        return view('pages.dashboard.main-menu.temuan.create', compact('penemu', 'insiden', 'opd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTemuanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTemuanRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validatedData = $request->all();

            $timestamp = Carbon::now()->format('Ymd_His'); // Format: YYYYMMDD_HHMMSS

            $filename = $timestamp . '_' . uniqid() . '.' . $request->gambar->extension();

            $request->gambar->storeAs('uploads/images/temuan', $filename);

            $validatedData['gambar'] = $filename;

            $temuan = Temuan::create($validatedData);

            foreach ($request->insiden_id as $insidenId) {
                TemuanInsiden::create(
                    [
                        'temuan_id' => $temuan->id,
                        'insiden_id' => $insidenId,
                    ]
                );
            }
        });

        return redirect()->route('temuan.index')->with(['status' => 'success', 'message' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Temuan  $temuan
     * @return \Illuminate\Http\Response
     */
    public function show(Temuan $temuan)
    {
        $temuan->load(['penemu', 'temuanInsiden.insiden', 'opd']);
        return view('pages.dashboard.main-menu.temuan.show', compact('temuan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Temuan  $temuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Temuan $temuan)
    {
        $penemu = Penemu::active()->orderBy('nama', 'asc')->pluck('nama', 'id');
        $insiden = Insiden::active()->orderBy('nama', 'asc')->pluck('nama', 'id');
        $opd = Opd::active()->orderBy('nama', 'asc')->pluck('nama', 'id');
        $selectedInsiden = $temuan->temuanInsiden->pluck('insiden_id')->toArray();

        return view('pages.dashboard.main-menu.temuan.edit', compact('temuan', 'penemu', 'insiden', 'opd', 'selectedInsiden'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTemuanRequest  $request
     * @param  \App\Models\Temuan  $temuan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTemuanRequest $request, Temuan $temuan)
    {
        DB::transaction(function () use ($temuan, $request) {
            $validatedData = $request->all();

            if ($request->gambar) {
                if (Storage::exists('uploads/images/temuan/' . $temuan->gambar)) {
                    Storage::delete('uploads/images/temuan/' . $temuan->gambar);
                }

                $timestamp = Carbon::now()->format('Ymd_His'); // Format: YYYYMMDD_HHMMSS

                $filename = $timestamp . '_' . uniqid() . '.' . $request->gambar->extension();

                $request->gambar->storeAs('uploads/images/temuan', $filename);

                $validatedData['gambar'] = $filename;
            }

            $temuan->update($validatedData);

            // Delete existing TemuanInsiden records
            $temuan->temuanInsiden()->delete();

            foreach ($request->insiden_id as $insidenId) {
                TemuanInsiden::create(
                    [
                        'temuan_id' => $temuan->id,
                        'insiden_id' => $insidenId,
                    ]
                );
            }
        });

        return redirect()->route('temuan.index')->with(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Temuan  $temuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Temuan $temuan)
    {
        DB::transaction(function () use ($temuan) {
            if (Storage::exists('uploads/images/temuan/' . $temuan->gambar)) {
                Storage::delete('uploads/images/temuan/' . $temuan->gambar);
            }

            // Delete related TemuanInsiden records
            $temuan->temuanInsiden()->delete();
            // Now delete the Temuan record
            $temuan->delete();
        });

        return redirect()->route('temuan.index')->with(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}
