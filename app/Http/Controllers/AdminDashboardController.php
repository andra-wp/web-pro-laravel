<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Penjualan;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalTerjual = Penjualan::count();
        $totalPendapatan = Penjualan::sum('harga');
        $totalMobilTersedia = Mobil::sum('stok');
        $totalPelanggan = User::where('role', 'user')->count();
        $penjualanTerbaru = Penjualan::with(['mobil', 'user'])->latest()->take(5)->get();

        return view('dashboard.admin', compact(
            'totalTerjual', 
            'totalPendapatan', 
            'totalMobilTersedia', 
            'totalPelanggan', 
            'penjualanTerbaru'
        ));
    }
}
