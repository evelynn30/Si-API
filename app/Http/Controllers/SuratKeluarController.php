<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\SifatSurat;
use App\Models\Temuan;
use App\Models\PerihalSurat;
use App\Http\Requests\StoreSuratKeluarRequest;
use App\Http\Requests\UpdateSuratKeluarRequest;
use App\Models\JenisSuratKeluar;
use App\Models\Opd;
use App\Models\SuratKeluarOpd;
use App\Models\SuratKeluarTemuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $suratKeluar = SuratKeluar::with(['jenisSuratKeluar:id,nama', 'sifatSurat:id,nama', 'perihalSurat:id,nama', 'suratKeluarTemuan.temuan', 'suratKeluarOpd.opd'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('tanggal', 'LIKE', "%{$search}%")
                        ->orWhere(function ($subQ) use ($search) {
                            try {
                                $date = Carbon::parse($search)->format('Y-m-d');
                                $subQ->whereDate('tanggal', $date);
                            } catch (\Exception $e) {
                                // If date parsing fails, ignore this condition
                            }
                        })
                        ->orWhere('nomor', 'LIKE', "%{$search}%")
                        ->orWhereHas('jenisSuratKeluar', function ($subQ) use ($search) {
                            $subQ->where('nama', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(5);

        return view('pages.dashboard.main-menu.surat_keluar.index', compact('suratKeluar', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $temuan = Temuan::with('opd:id,nama')->select('id', 'tanggal', 'opd_id')->orderBy('tanggal', 'desc')->get();
        $opd = Opd::orderBy('nama')->pluck('nama', 'id');


        $temuan = $temuan->mapWithKeys(function ($item) {
            return [$item->id => Carbon::parse($item->tanggal)->format('d-m-Y H:i') . ' - ' . $item->opd->nama];
        });

        $jenisSuratKeluar = [];
        $jenisSuratKeluarTemp = JenisSuratKeluar::pluck('nama', 'id');
        foreach ($jenisSuratKeluarTemp as $key => $value) {
            $data = [
                'value' => $key,
                'label' => $value
            ];

            array_push($jenisSuratKeluar, $data);
        }

        $sifatSurat = SifatSurat::orderBy('nama', 'asc')->pluck('nama', 'id');
        $perihalSurat = PerihalSurat::orderBy('nama', 'asc')->pluck('nama', 'id');
        return view('pages.dashboard.main-menu.surat_keluar.create', compact('temuan', 'sifatSurat', 'perihalSurat', 'jenisSuratKeluar', 'opd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSuratKeluarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSuratKeluarRequest $request)
    {

        DB::transaction(function () use ($request) {

            $validatedData = $request->all();

            $timestamp = Carbon::now()->format('Ymd_His'); // Format: YYYYMMDD_HHMMSS

            $filename = $timestamp . '_' . uniqid() . '.' . $request->file->extension();

            $request->file->storeAs('uploads/documents/surat-keluar', $filename);

            $validatedData['file'] = $filename;

            $suratKeluar = SuratKeluar::create($validatedData);


            if ($request->data_temuan) {
                foreach ($request->data_temuan as $temuanId) {
                    // Create relation in SuratKeluarTemuan table
                    SuratKeluarTemuan::create([
                        'surat_keluar_id' => $suratKeluar->id,
                        'temuan_id' => $temuanId,
                    ]);

                    // Automatically update the status of Temuan to 1 (Menunggu Tanggapan)
                    $temuan = Temuan::find($temuanId);
                    if ($temuan && $temuan->status == 0) {
                        $temuan->updateStatusToMenungguTanggapan();
                    }
                }
            }
            // If there is OPD data instead of Temuan
            elseif ($request->opd) {
                foreach ($request->opd as $opdId) {
                    // Create relation in SuratKeluarOpd table
                    SuratKeluarOpd::create([
                        'surat_keluar_id' => $suratKeluar->id,
                        'opd_id' => $opdId,
                    ]);
                }
            }
        });

        return redirect()->route('surat_keluar.index')->with(['status' => 'success', 'message' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function show(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load(['jenisSuratKeluar', 'sifatSurat', 'perihalSurat', 'suratKeluarTemuan.temuan', 'suratKeluarOpd.opd']);
        return view('pages.dashboard.main-menu.surat_keluar.show', compact('suratKeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(SuratKeluar $suratKeluar)
    {
        $temuan = Temuan::with('opd:id,nama')->select('id', 'tanggal', 'opd_id')->latest()->get();
        $opd = Opd::orderBy('nama')->pluck('nama', 'id');

        $temuan = $temuan->mapWithKeys(function ($item) {
            return [$item->id => Carbon::parse($item->tanggal)->format('d-m-Y H:i') . ' - ' . $item->opd->nama];
        });

        $jenisSuratKeluar = [];
        $jenisSuratKeluarTemp = JenisSuratKeluar::pluck('nama', 'id');
        foreach ($jenisSuratKeluarTemp as $key => $value) {
            $data = [
                'value' => $key,
                'label' => $value
            ];

            array_push($jenisSuratKeluar, $data);
        }

        $sifatSurat = SifatSurat::orderBy('nama', 'asc')->pluck('nama', 'id');
        $perihalSurat = PerihalSurat::orderBy('nama', 'asc')->pluck('nama', 'id');
        $selectedTemuan = $suratKeluar->suratKeluarTemuan->pluck('temuan_id')->toArray();
        $selectedOpd = $suratKeluar->suratKeluarOpd->pluck('opd_id')->toArray();
        return view('pages.dashboard.main-menu.surat_keluar.edit', compact('suratKeluar', 'temuan', 'sifatSurat', 'opd', 'perihalSurat', 'jenisSuratKeluar', 'selectedTemuan', 'selectedOpd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSuratKeluarRequest  $request
     * @param  \App\Models\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSuratKeluarRequest $request, SuratKeluar $suratKeluar)
    {

        DB::transaction(function () use ($request, $suratKeluar) {

            $validatedData = $request->all();

            $suratKeluar->suratKeluarTemuan()->delete();
            $suratKeluar->suratKeluarOpd()->delete();

            if ($request->file) {
                if (Storage::exists('uploads/documents/surat-keluar/' . $suratKeluar->file)) {
                    Storage::delete('uploads/documents/surat-keluar/' . $suratKeluar->file);
                }

                $timestamp = Carbon::now()->format('Ymd_His'); // Format: YYYYMMDD_HHMMSS

                $filename = $timestamp . '_' . uniqid() . '.' . $request->file->extension();

                $request->file->storeAs('uploads/documents/surat-keluar', $filename);

                $validatedData['file'] = $filename;
            }

            $suratKeluar->update($validatedData);

            if ($request->data_temuan) {
                foreach ($request->data_temuan as $temuanId) {
                    SuratKeluarTemuan::create(
                        [
                            'surat_keluar_id' => $suratKeluar->id,
                            'temuan_id' => $temuanId,
                        ]
                    );
                }
            } elseif ($request->opd) {
                foreach ($request->opd as $opdId) {
                    SuratKeluarOpd::create(
                        [
                            'surat_keluar_id' => $suratKeluar->id,
                            'opd_id' => $opdId,
                        ]
                    );
                }
            }
        });

        return redirect()->route('surat_keluar.index')->with(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuratKeluar $suratKeluar)
    {

        DB::transaction(function () use ($suratKeluar) {

            if (Storage::exists('uploads/documents/surat-keluar/' . $suratKeluar->file)) {
                Storage::delete('uploads/documents/surat-keluar/' . $suratKeluar->file);
            }

            $suratKeluar->suratKeluarTemuan()->delete();
            $suratKeluar->suratKeluarOpd()->delete();

            $suratKeluar->delete();
        });
        return redirect()->route('surat_keluar.index')->with(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}
