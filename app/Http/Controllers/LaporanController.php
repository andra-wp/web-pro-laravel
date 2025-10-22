<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;

class LaporanController extends Controller
{
    public function index()
    {
        // Total pendapatan dari semua penjualan
        $totalPendapatan = Penjualan::sum('harga');

        // Total mobil terjual
        $totalMobil = Penjualan::count();

        // Rata-rata transaksi
        $rataTransaksi = Penjualan::avg('harga');

        return view('dashboard.laporan', compact(
            'totalPendapatan',
            'totalMobil',
            'rataTransaksi'
        ));
    }
}
