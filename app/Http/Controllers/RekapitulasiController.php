<?php

namespace App\Http\Controllers;

use App\Exports\RekapitulasiExport;
use App\Exports\TemuanExport;
use App\Models\Insiden;
use App\Models\JenisSuratKeluar;
use App\Models\JenisSuratMasuk;
use App\Models\Opd;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\Temuan;
use App\Models\TemuanInsiden;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapitulasiController extends Controller
{
    private function queryTables($request)
    {
        // Filter request
        $jenisReq = $request->jenis;
        $opdReq = $request->opd_id;
        $startDateReq = $request->startDate;
        $endDateReq = $request->endDate;
        $endDateReq = Carbon::parse($endDateReq)->addDay();

        $selectedInsiden = $request->insiden;
        $selectedJenisSuratKeluar = $request->jenis_surat_keluar;
        $selectedJenisSuratMasuk = $request->jenis_surat_masuk;


        if ($jenisReq == 1) { // Temuan
            $data = Temuan::with(['temuanInsiden' => function ($query) use ($selectedInsiden) {
                // Hanya tambah kondisi jika $selectedInsiden diberikan
                $query->when($selectedInsiden, function ($query) use ($selectedInsiden) {
                    $query->whereIn('insiden_id', $selectedInsiden);
                });
            }])
                ->whereBetween('tanggal', [$startDateReq, $endDateReq]) // Tambahkan satu hari ke endDateReq
                ->when($opdReq, function ($query) use ($opdReq) {
                    // Filter berdasarkan opd_id jika disediakan
                    $query->where('opd_id', $opdReq);
                })
                ->whereHas('temuanInsiden', function ($query) use ($selectedInsiden) {
                    // Hanya tambahkan kondisi whereIn jika $selectedInsiden diberikan
                    $query->when($selectedInsiden, function ($query) use ($selectedInsiden) {
                        $query->whereIn('insiden_id', $selectedInsiden);
                    });
                })
                ->orderBy('tanggal', 'desc')
                ->get();
        } else if ($jenisReq == 2) { // Surat Keluar
            $data = SuratKeluar::with(['suratKeluarTemuan.temuan.opd', 'suratKeluarOpd.opd'])
                ->whereBetween('tanggal', [$startDateReq, $endDateReq])
                ->when($opdReq, function ($query) use ($opdReq) {
                    $query->where(function ($q) use ($opdReq) {
                        $q->whereHas('suratKeluarTemuan.temuan', function ($q2) use ($opdReq) {
                            $q2->where('opd_id', $opdReq);
                        });
                        $q->orWhereHas('suratKeluarOpd', function ($q2) use ($opdReq) {
                            $q2->where('opd_id', $opdReq);
                        });
                    });
                })
                ->when($selectedJenisSuratKeluar, function ($query) use ($selectedJenisSuratKeluar) {
                    $query->whereIn('jenis_surat_keluar_id', $selectedJenisSuratKeluar);
                })
                ->orderBy('tanggal', 'desc')
                ->get();
        } else if ($jenisReq == 3) { // Surat Masuk
            $data = SuratMasuk::with(['suratMasukOpd.opd', 'suratMasukTerkaitKeluar.suratKeluar.suratKeluarTemuan.temuan', 'suratMasukTerkaitKeluar.suratKeluar.suratKeluarOpd.opd'])
                ->whereBetween('tanggal', [$startDateReq, $endDateReq])
                ->when($opdReq, function ($query, $opdReq) {
                    $query->where(function ($q) use ($opdReq) {
                        $q->whereHas('suratMasukOpd', function ($subQuery) use ($opdReq) {
                            $subQuery->where('opd_id', $opdReq); // Only include records matching the specific OPD
                        });

                        $q->orWhereHas('suratMasukTerkaitKeluar.suratKeluar.suratKeluarTemuan.temuan', function ($subQuery) use ($opdReq) {
                            $subQuery->where('opd_id', $opdReq);
                        })->orWhereHas('suratMasukTerkaitKeluar.suratKeluar.suratKeluarOpd', function ($subQuery) use ($opdReq) {
                            $subQuery->where('opd_id', $opdReq);
                        });
                    });
                })
                // Filter by selectedJenisSuratMasuk if provided
                ->when($selectedJenisSuratMasuk, function ($query) use ($selectedJenisSuratMasuk) {
                    $query->whereIn('jenis_surat_masuk_id', $selectedJenisSuratMasuk);
                })
                // Order results by date, newest first
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        return $data;
    }

    private function queryDiagram($request)
    {
        // Filter request
        $jenisReq = $request->jenis;
        $opdReq = $request->opd_id;
        $startDateReq = $request->startDate;
        $endDateReq = $request->endDate;
        $endDateReq = Carbon::parse($endDateReq)->addDay();

        if ($jenisReq == 1) { // Temuan
            // Jumlah Terdampak berdasarkan Bulan
            $chartJumlahTerdampak = Temuan::withCount('temuanInsiden')
                ->whereBetween('tanggal', [$startDateReq, $endDateReq])
                ->when($opdReq, function ($query, $opdReq) {
                    return $query->where('opd_id', $opdReq);
                })
                ->select('id', 'tanggal')
                ->orderBy('tanggal', 'asc')
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => Carbon::parse($item->tanggal)->format('M y'),
                        'jumlah_temuan_insiden' => $item->temuanInsiden->count(),
                    ];
                })
                ->toArray();

            $tanggalArrayJumlahTerdampak = array_column($chartJumlahTerdampak, 'tanggal');
            $jumlahInsidenArrayJumlahTerdampak = array_column($chartJumlahTerdampak, 'jumlah_temuan_insiden');

            $chartJumlahTerdampak = [
                'tanggal' => $tanggalArrayJumlahTerdampak,
                'jumlah_insiden' => $jumlahInsidenArrayJumlahTerdampak,
            ];

            // Jumlah Insiden Per-OPD
            $chartJumlahInsidenOPD = Temuan::with('opd:id,nama')
                ->whereBetween('tanggal', [$startDateReq, $endDateReq])
                ->when($opdReq, function ($query, $opdReq) {
                    return $query->where('opd_id', $opdReq);
                })
                ->select('opd_id')
                ->selectRaw('GROUP_CONCAT(id) as temuan_id')
                ->selectRaw('count(*) as jumlah_temuan')
                ->groupBy('opd_id')
                ->orderBy('jumlah_temuan', 'desc')
                ->get()
                ->map(function ($item) {
                    $temuanIds = explode(',', $item->temuan_id);
                    $jumlahTemuanInsiden = TemuanInsiden::whereIn('temuan_id', $temuanIds)->count();
                    return [
                        'nama_opd' => implode(' ', array_slice(explode(' ', $item->opd->nama), 0, 3)) . ' ...',
                        'jumlah_temuan' => $item->jumlah_temuan,
                        'jumlah_insiden' => $jumlahTemuanInsiden,
                    ];
                })
                ->toArray();

            $namaOPDArrayJumlahInsidenOPD = array_column($chartJumlahInsidenOPD, 'nama_opd');
            $jumlahTemuanArrayJumlahInsidenOPD = array_column($chartJumlahInsidenOPD, 'jumlah_temuan');
            $jumlahInsidenArrayJumlahInsidenOPD = array_column($chartJumlahInsidenOPD, 'jumlah_insiden');

            $chartJumlahInsidenOPD = [
                'nama_opd' => $namaOPDArrayJumlahInsidenOPD,
                'jumlah_temuan' => $jumlahTemuanArrayJumlahInsidenOPD,
                'jumlah_insiden' => $jumlahInsidenArrayJumlahInsidenOPD,
            ];

            // Jumlah Per-Status Temuan
            $chartJumlahStatusTemuan = Temuan::whereBetween('tanggal', [$startDateReq, $endDateReq])
                ->when($opdReq, function ($query, $opdReq) {
                    return $query->where('opd_id', $opdReq);
                })
                ->select('status')
                ->selectRaw('count(*) as jumlah_status')
                ->groupBy('status')
                ->orderBy('status', 'asc') // Mengurutkan berdasarkan jumlah temuan secara menurun
                ->get()
                ->map(function ($item) {
                    $statusNama = '';
                    if ($item->status == 0) {
                        $statusNama = 'Baru Ditemukan';
                    } else if ($item->status == 1) {
                        $statusNama = 'Menunggu Tanggapan';
                    } else if ($item->status == 2) {
                        $statusNama = 'Dalam Penanganan';
                    } else if ($item->status == 3) {
                        $statusNama = 'Selesai';
                    }
                    return [
                        'status' => $statusNama,
                        'jumlah' => $item->jumlah_status,
                    ];
                })
                ->toArray();

            $statusArrayJumlahStatusTemuan = array_column($chartJumlahStatusTemuan, 'status');
            $jumlahArrayJumlahStatusTemuan = array_column($chartJumlahStatusTemuan, 'jumlah');

            $chartJumlahStatusTemuan = [
                'status' => $statusArrayJumlahStatusTemuan,
                'jumlah' => $jumlahArrayJumlahStatusTemuan,
            ];

            // Jumlah Per-Insiden
            $chartJumlahInsiden = TemuanInsiden::with(['insiden', 'temuan'])
                ->whereHas('temuan', function ($q) use ($startDateReq, $endDateReq, $opdReq) {
                    $q->whereBetween('tanggal', [$startDateReq, $endDateReq]);
                    $q->when($opdReq, function ($query, $opdReq) {
                        return $query->where('opd_id', $opdReq);
                    });
                })
                ->select('insiden_id')
                ->selectRaw('count(*) as jumlah')
                ->groupBy('insiden_id')
                ->orderBy('jumlah', 'desc') // Mengurutkan berdasarkan jumlah temuan secara menurun
                ->get()
                ->map(function ($item) {
                    return [
                        'insiden' => $item->insiden->nama,
                        'jumlah' => $item->jumlah,
                    ];
                })
                ->toArray();

            $insidenArrayJumlahInsiden = array_column($chartJumlahInsiden, 'insiden');
            $jumlahArrayJumlahInsiden = array_column($chartJumlahInsiden, 'jumlah');

            $chartJumlahInsiden = [
                'insiden' => $insidenArrayJumlahInsiden,
                'jumlah' => $jumlahArrayJumlahInsiden,
            ];

            $data = [
                'jumlahTerdampak' => $chartJumlahTerdampak,
                'jumlahInsidenOPD' => $chartJumlahInsidenOPD,
                'statusTemuan' => $chartJumlahStatusTemuan,
                'jumlahInsiden' => $chartJumlahInsiden
            ];
        } else if ($jenisReq == 2) { // Surat Keluar
            $countSuratKeluarOPD = Opd::with([
                'suratKeluarOpd.suratKeluar' => function ($query) use ($startDateReq, $endDateReq) {
                    $query->whereBetween('tanggal', [$startDateReq, $endDateReq]);
                },
                'temuan.suratKeluarTemuan.suratKeluar' => function ($query) use ($startDateReq, $endDateReq) {
                    $query->whereBetween('tanggal', [$startDateReq, $endDateReq]);
                }
            ])->when($opdReq, function ($query, $opdReq) {
                return $query->where('id', $opdReq);
            })
                ->orderBy('nama')
                ->get()
                ->map(function ($item) use ($startDateReq, $endDateReq) {
                    $suratKeluarOpdCount = $item->suratKeluarOpd()
                        ->whereHas('suratKeluar', function ($q) use ($startDateReq, $endDateReq) {
                            $q->whereBetween('tanggal', [$startDateReq, $endDateReq]);
                        })->count();
                    $suratKeluarTemuanCount = $item->temuan->sum(function ($temuan) use ($startDateReq, $endDateReq) {
                        return $temuan->suratKeluarTemuan()
                            ->whereHas('suratKeluar', function ($q) use ($startDateReq, $endDateReq) {
                                $q->whereBetween('tanggal', [$startDateReq, $endDateReq]);
                            })->count();
                    });
                    $item->totalJumlah = $suratKeluarOpdCount + $suratKeluarTemuanCount;
                    return $item;
                })->sortByDesc('totalJumlah');

            $chartJenisSuratKeluar = SuratKeluar::with(['jenisSuratKeluar'])
                ->select('jenis_surat_keluar_id')
                ->selectRaw('count(*) as jumlah')
                ->groupBy('jenis_surat_keluar_id')
                ->orderBy('jumlah', 'desc') // Mengurutkan berdasarkan jumlah temuan secara menurun
                ->get()
                ->map(function ($item) {
                    return [
                        'jenis' => $item->jenisSuratKeluar->nama,
                        'jumlah' => $item->jumlah,
                    ];
                })
                ->toArray();

            $jenisArrayJumlahJenisSuratKeluar = array_column($chartJenisSuratKeluar, 'jenis');
            $jumlahArrayJumlahJenisSuratKeluar = array_column($chartJenisSuratKeluar, 'jumlah');

            $chartJenisSuratKeluar = [
                'jenis' => $jenisArrayJumlahJenisSuratKeluar,
                'jumlah' => $jumlahArrayJumlahJenisSuratKeluar,
            ];

            $data = [
                'jumlahSuratKeluarPerOPD' => $countSuratKeluarOPD,
                'jumlahJenisSuratKeluar' => $chartJenisSuratKeluar
            ];
        } else if ($jenisReq == 3) { //Surat Masuk
            $countSuratMasukOPD = Opd::with([
                'suratMasukOpd.suratMasuk' => function ($query) use ($startDateReq, $endDateReq) {
                    // Filter berdasarkan tanggal pada suratMasukOpd
                    $query->whereBetween('tanggal', [$startDateReq, $endDateReq]);
                },
                'temuan.suratKeluarTemuan.suratKeluar.suratMasukTerkaitKeluar.suratMasuk' => function ($query) use ($startDateReq, $endDateReq) {
                    // Filter berdasarkan tanggal pada suratMasukTerkaitKeluar melalui suratKeluar dari suratKeluarTemuan
                    $query->whereBetween('tanggal', [$startDateReq, $endDateReq]);
                },
                'suratKeluarOpd.suratKeluar.suratMasukTerkaitKeluar.suratMasuk' => function ($query) use ($startDateReq, $endDateReq) {
                    // Filter berdasarkan tanggal pada suratMasukTerkaitKeluar melalui suratKeluarOpd
                    $query->whereBetween('tanggal', [$startDateReq, $endDateReq]);
                }
            ])->when($opdReq, function ($query, $opdReq) {
                return $query->where('id', $opdReq);
            })
                ->orderBy('nama')
                ->get()
                ->map(function ($item) use ($startDateReq, $endDateReq) {
                    $suratMasukOpdCount = $item->suratMasukOpd()
                        ->whereHas('suratMasuk', function ($q) use ($startDateReq, $endDateReq) {
                            $q->whereBetween('tanggal', [$startDateReq, $endDateReq]);
                        })->count();

                    $suratMasukTerkaitSuratKeluar1Count = $item->temuan
                        ->flatMap(function ($temuan) use ($startDateReq, $endDateReq) {
                            return $temuan->suratKeluarTemuan
                                ->flatMap(function ($suratKeluarTemuan) use ($startDateReq, $endDateReq) {
                                    return $suratKeluarTemuan->suratKeluar->suratMasukTerkaitKeluar->filter(function ($suratMasukTerkaitKeluar) use ($startDateReq, $endDateReq) {
                                        // Pastikan suratMasuk tidak null sebelum memeriksa tanggalnya
                                        return $suratMasukTerkaitKeluar->suratMasuk
                                            && $suratMasukTerkaitKeluar->suratMasuk->tanggal >= $startDateReq
                                            && $suratMasukTerkaitKeluar->suratMasuk->tanggal <= $endDateReq;
                                    });
                                });
                        })
                        ->count();

                    $suratMasukTerkaitSuratKeluar2Count = $item->suratKeluarOpd
                        ->flatMap(function ($suratKeluarOpd) use ($startDateReq, $endDateReq) {
                            return $suratKeluarOpd->suratKeluar->suratMasukTerkaitKeluar->filter(function ($suratMasukTerkaitKeluar) use ($startDateReq, $endDateReq) {
                                // Pastikan suratMasuk tidak null sebelum memeriksa tanggalnya
                                return $suratMasukTerkaitKeluar->suratMasuk
                                    && $suratMasukTerkaitKeluar->suratMasuk->tanggal >= $startDateReq
                                    && $suratMasukTerkaitKeluar->suratMasuk->tanggal <= $endDateReq;
                            });
                        })
                        ->count();

                    $item->totalJumlah = $suratMasukOpdCount + $suratMasukTerkaitSuratKeluar1Count + $suratMasukTerkaitSuratKeluar2Count;

                    return $item;
                })
                ->sortByDesc('totalJumlah');


            $chartJenisSuratMasuk = SuratMasuk::with('jenisSuratMasuk')
                ->select('jenis_surat_masuk_id')
                ->selectRaw('count(*) as jumlah')
                ->groupBy('jenis_surat_masuk_id')
                ->orderBy('jumlah', 'desc') // Mengurutkan berdasarkan jumlah temuan secara menurun
                ->get()
                ->map(function ($item) {
                    return [
                        'jenis' => $item->jenisSuratMasuk->nama,
                        'jumlah' => $item->jumlah,
                    ];
                })
                ->toArray();

            $jenisArrayJumlahJenisSuratMasuk = array_column($chartJenisSuratMasuk, 'jenis');
            $jumlahArrayJumlahJenisSuratMasuk = array_column($chartJenisSuratMasuk, 'jumlah');

            $chartJenisSuratMasuk = [
                'jenis' => $jenisArrayJumlahJenisSuratMasuk,
                'jumlah' => $jumlahArrayJumlahJenisSuratMasuk,
            ];

            $data = [
                'jumlahSuratMasukPerOPD' => $countSuratMasukOPD,
                'jumlahJenisSuratMasuk' => $chartJenisSuratMasuk
            ];
        }

        return $data;
    }

    public function index(Request $request)
    {
        $opd = Opd::select('id', 'nama')->get();

        $startDateTemuan = Carbon::parse(Temuan::min('tanggal'))->format('Y-m-d');
        $endDateTemuan = Carbon::parse(Temuan::max('tanggal'))->format('Y-m-d');

        $startDateSuratMasuk = Carbon::parse(SuratMasuk::min('tanggal'))->format('Y-m-d');
        $endDateSuratMasuk = Carbon::parse(SuratMasuk::max('tanggal'))->format('Y-m-d');

        $startDateSuratKeluar = Carbon::parse(SuratKeluar::min('tanggal'))->format('Y-m-d');
        $endDateSuratKeluar = Carbon::parse(SuratKeluar::max('tanggal'))->format('Y-m-d');

        $insiden = Insiden::orderBy('nama', 'asc')->pluck('nama', 'id');

        $jenisSuratKeluar = JenisSuratKeluar::pluck('nama', 'id');

        $jenisSuratMasuk = JenisSuratMasuk::pluck('nama', 'id');


        // if request ajax
        if ($request->ajax()) {
            $tabInfo = $request->tab_info;
            $jenisReq = $request->jenis;
            $opdReq = $request->opd_id;

            if ($tabInfo == 'table-tab') {
                $data = $this->queryTables($request);
                if ($jenisReq == 1) {
                    return view('pages.dashboard.main-menu.rekapitulasi.partials.cards.tables.temuan-card', compact('data'));
                } elseif ($jenisReq == 2) {
                    return view('pages.dashboard.main-menu.rekapitulasi.partials.cards.tables.surat-keluar-card', compact('data', 'opdReq'));
                } else if ($jenisReq == 3) {
                    return view('pages.dashboard.main-menu.rekapitulasi.partials.cards.tables.surat-masuk-card', compact('data', 'opdReq'));
                }
            } else  if ($tabInfo == 'diagram-tab') {
                $data = $this->queryDiagram($request);
                if ($jenisReq == 1) {
                    $chartJumlahTerdampak = $data['jumlahTerdampak'];
                    $chartJumlahInsidenOPD = $data['jumlahInsidenOPD'];
                    $chartJumlahStatusTemuan = $data['statusTemuan'];
                    $chartJumlahInsiden = $data['jumlahInsiden'];

                    return view('pages.dashboard.main-menu.rekapitulasi.partials.cards.diagram.temuan-card', compact('chartJumlahTerdampak', 'chartJumlahInsidenOPD', 'chartJumlahStatusTemuan', 'chartJumlahInsiden'));
                } else if ($jenisReq == 2) {
                    $opd = $data['jumlahSuratKeluarPerOPD'];
                    $chartJenisSuratKeluar = $data['jumlahJenisSuratKeluar'];

                    return view('pages.dashboard.main-menu.rekapitulasi.partials.cards.diagram.surat-keluar-card', compact('opd', 'chartJenisSuratKeluar'));
                } else if ($jenisReq == 3) {
                    $opd = $data['jumlahSuratMasukPerOPD'];
                    $chartJenisSuratMasuk = $data['jumlahJenisSuratMasuk'];

                    return view('pages.dashboard.main-menu.rekapitulasi.partials.cards.diagram.surat-masuk-card', compact('opd', 'chartJenisSuratMasuk'));
                }
            } else {
                abort(404);
            }
        }

        return view('pages.dashboard.main-menu.rekapitulasi.index', compact('opd', 'insiden', 'jenisSuratKeluar', 'jenisSuratMasuk', 'startDateTemuan', 'endDateTemuan', 'startDateSuratMasuk', 'endDateSuratMasuk', 'startDateSuratKeluar', 'endDateSuratKeluar'));
    }

    public function exportRekapitulasi(Request $request)
    {
        $data = $this->queryTables($request);
        $typeExport = $request->jenis;

        if ($typeExport == 1) {
            $filename = 'Temuan_' . Carbon::now()->format('Y-m-d') . '.xlsx';
        } else if ($typeExport == 2) {
            $filename = 'Surat_Keluar_' . Carbon::now()->format('Y-m-d') . '.xlsx';
        } else if ($typeExport == 3) {
            $filename = 'Surat_Masuk_' . Carbon::now()->format('Y-m-d') . '.xlsx';
        } else {
            $filename = 'Rekapitulasi_' . Carbon::now()->format('Y-m-d') . '.xlsx';
        }

        return Excel::download(new RekapitulasiExport($data, $typeExport), $filename);
    }
}
