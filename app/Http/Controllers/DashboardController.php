<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Temuan;
use App\Models\TemuanInsiden;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $temuanCount = Temuan::count();
        $insidenCount = TemuanInsiden::count();
        $opdCount = Opd::count();

        // Jumlah Per-Status Temuan
        $chartJumlahStatusTemuan = Temuan::select('status')
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

        // Jumlah Terdampak berdasarkan Bulan
        $chartJumlahTerdampak = Temuan::withCount('temuanInsiden')
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

        return view('pages.dashboard.index', compact('temuanCount', 'insidenCount', 'opdCount', 'chartJumlahStatusTemuan', 'chartJumlahInsiden', 'chartJumlahTerdampak'));
    }
}
