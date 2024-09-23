<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Http\Requests\StoreSuratMasukRequest;
use App\Http\Requests\UpdateSuratMasukRequest;
use App\Models\SifatSurat;
use App\Models\PerihalSurat;
use App\Models\JenisSuratMasuk;
use App\Models\Opd;
use App\Models\SuratKeluar;
use App\Models\SuratKeluarTemuan;
use App\Models\SuratMasukOpd;
use App\Models\SuratMasukTerkaitKeluar;
use App\Models\Temuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $suratMasuk = SuratMasuk::with(['jenisSuratMasuk:id,nama', 'sifatSurat:id,nama', 'perihalSurat:id,nama', 'suratMasukOpd.opd'])
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
                        ->orWhereHas('jenisSuratMasuk', function ($subQ) use ($search) {
                            $subQ->where('nama', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(5); // Adjust the number 5 to the desired number of items per page

        // Pass the retrieved data to the view
        return view('pages.dashboard.main-menu.surat_masuk.index', compact('suratMasuk', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suratKeluar = SuratKeluar::orderBy('tanggal', 'desc')->get();
        $opd = Opd::orderBy('nama')->pluck('nama', 'id');

        $suratKeluar = $suratKeluar->mapWithKeys(function ($item) {
            return [$item->id => Carbon::parse($item->tanggal)->format('d-m-Y') . ' - ' . $item->nomor . ' | ' . $item->jenisSuratKeluar->nama . ' | ' . $item->perihalSurat->nama];
        });

        $jenisSuratMasuk = [];
        $jenisSuratMasukTemp = JenisSuratMasuk::pluck('nama', 'id');
        foreach ($jenisSuratMasukTemp as $key => $value) {
            $data = [
                'value' => $key,
                'label' => $value
            ];

            array_push($jenisSuratMasuk, $data);
        }

        $sifatSurat = SifatSurat::orderBy('nama', 'asc')->pluck('nama', 'id');
        $perihalSurat = PerihalSurat::orderBy('nama', 'asc')->pluck('nama', 'id');
        return view('pages.dashboard.main-menu.surat_masuk.create', compact('suratKeluar', 'sifatSurat', 'perihalSurat', 'jenisSuratMasuk', 'opd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSuratMasukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSuratMasukRequest $request)
    {

        DB::transaction(function () use ($request) {

            $validatedData = $request->all();

            $timestamp = Carbon::now()->format('Ymd_His'); // Format: YYYYMMDD_HHMMSS

            $filename = $timestamp . '_' . uniqid() . '.' . $request->file->extension();

            $request->file->storeAs('uploads/documents/surat-masuk', $filename);

            $validatedData['file'] = $filename;

            $suratMasuk = SuratMasuk::create($validatedData);

            if ($request->data_surat_keluar) {
                foreach ($request->data_surat_keluar as $suratKeluarId) {
                    // Create relation in SuratMasukTerkaitKeluar table
                    SuratMasukTerkaitKeluar::create([
                        'surat_masuk_id' => $suratMasuk->id,
                        'surat_keluar_id' => $suratKeluarId,
                    ]);

                    // Check if the Surat Keluar is related to any Temuan and update its status
                    $temuanTerkait = SuratKeluarTemuan::where('surat_keluar_id', $suratKeluarId)->get();

                    foreach ($temuanTerkait as $temuanLink) {
                        $temuan = Temuan::find($temuanLink->temuan_id);
                        if ($temuan && $temuan->status == 1) {
                            $temuan->updateStatusToDalamPenanganan();
                        }
                    }
                }
            }
            // If there is OPD data instead of Surat Keluar
            elseif ($request->opd) {
                foreach ($request->opd as $opdId) {
                    // Create relation in SuratMasukOpd table
                    SuratMasukOpd::create([
                        'surat_masuk_id' => $suratMasuk->id,
                        'opd_id' => $opdId,
                    ]);
                }
            }
        });

        return redirect()->route('surat_masuk.index')->with(['status' => 'success', 'message' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuratMasuk  $suratMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load(['jenisSuratMasuk', 'sifatSurat', 'perihalSurat', 'suratMasukTerkaitKeluar.suratKeluar', 'suratMasukOpd.opd']);
        return view('pages.dashboard.main-menu.surat_masuk.show', compact('suratMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuratMasuk  $suratMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        $suratKeluar = SuratKeluar::orderBy('tanggal', 'desc')->get();
        $opd = Opd::orderBy('nama')->pluck('nama', 'id');

        $suratKeluar = $suratKeluar->mapWithKeys(function ($item) {
            return [$item->id => Carbon::parse($item->tanggal)->format('d-m-Y') . ' - ' . $item->nomor . ' | ' . $item->jenisSuratKeluar->nama . ' | ' . $item->perihalSurat->nama];
        });

        $jenisSuratMasuk = [];
        $jenisSuratMasukTemp = JenisSuratMasuk::pluck('nama', 'id');
        foreach ($jenisSuratMasukTemp as $key => $value) {
            $data = [
                'value' => $key,
                'label' => $value
            ];

            array_push($jenisSuratMasuk, $data);
        }

        $sifatSurat = SifatSurat::orderBy('nama', 'asc')->pluck('nama', 'id');
        $perihalSurat = PerihalSurat::orderBy('nama', 'asc')->pluck('nama', 'id');
        $selectedSuratKeluar = $suratMasuk->suratMasukTerkaitKeluar->pluck('surat_keluar_id')->toArray();
        $selectedOpd = $suratMasuk->suratMasukOpd->pluck('opd_id')->toArray();

        return view('pages.dashboard.main-menu.surat_masuk.edit', compact('suratMasuk', 'suratKeluar', 'sifatSurat', 'opd', 'perihalSurat', 'jenisSuratMasuk', 'selectedSuratKeluar',  'selectedOpd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSuratMasukRequest  $request
     * @param  \App\Models\SuratMasuk  $suratMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSuratMasukRequest $request, SuratMasuk $suratMasuk)
    {
        DB::transaction(function () use ($request, $suratMasuk) {

            $validatedData = $request->all();

            $suratMasuk->suratMasukTerkaitKeluar()->delete();
            $suratMasuk->suratMasukOpd()->delete();

            if ($request->file) {
                if (Storage::exists('uploads/documents/surat-masuk/' . $suratMasuk->file)) {
                    Storage::delete('uploads/documents/surat-masuk/' . $suratMasuk->file);
                }

                $timestamp = Carbon::now()->format('Ymd_His'); // Format: YYYYMMDD_HHMMSS

                $filename = $timestamp . '_' . uniqid() . '.' . $request->file->extension();

                $request->file->storeAs('uploads/documents/surat-masuk', $filename);

                $validatedData['file'] = $filename;
            }

            $suratMasuk->update($validatedData);

            if ($request->data_surat_keluar) {
                foreach ($request->data_surat_keluar as $suratKeluarId) {
                    SuratMasukTerkaitKeluar::create(
                        [
                            'surat_masuk_id' => $suratMasuk->id,
                            'surat_keluar_id' => $suratKeluarId,
                        ]
                    );
                }
            } elseif ($request->opd) {
                foreach ($request->opd as $opdId) {
                    SuratMasukOpd::create(
                        [
                            'surat_masuk_id' => $suratMasuk->id,
                            'opd_id' => $opdId,
                        ]
                    );
                }
            }
        });

        return redirect()->route('surat_masuk.index')->with(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuratMasuk  $suratMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        DB::transaction(function () use ($suratMasuk) {

            if (Storage::exists('uploads/documents/surat-masuk/' . $suratMasuk->file)) {
                Storage::delete('uploads/documents/surat-masuk/' . $suratMasuk->file);
            }
            // Delete related records first
            $suratMasuk->suratMasukTerkaitKeluar()->delete();
            $suratMasuk->suratMasukOpd()->delete();

            // Then delete the SuratMasuk record
            $suratMasuk->delete();
        });

        return redirect()->route('surat_masuk.index')->with(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}
