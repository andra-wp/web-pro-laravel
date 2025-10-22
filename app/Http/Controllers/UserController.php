<?php
namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 🔹 Ambil semua mobil yang masih tersedia
        $mobils = Mobil::where('stok', '>', 0)->get();

        // 🔹 Ambil semua pembelian user saat ini
        $penjualans = Penjualan::where('user_id', $user->id)
            ->with('mobil')
            ->latest()
            ->get();

        // 🔹 Hitung total mobil dibeli
        $totalMobilDibeli = $penjualans->count();

        // 🔹 Hitung total pengeluaran
        $totalPengeluaran = $penjualans->sum('harga');

        // 🔹 Hitung poin reward (misal: 40 poin per pembelian)
        $poinReward = $totalMobilDibeli * 40;

        return view('dashboard.user', compact(
            'user',
            'mobils',
            'penjualans',
            'totalMobilDibeli',
            'totalPengeluaran',
            'poinReward'
        ));
    }

    public function beli(Request $request, $id)
    {
        $mobil = Mobil::findOrFail($id);

        // Cegah beli mobil yang stoknya habis
        if ($mobil->stok <= 0) {
            return back()->with('error', 'Mobil sudah habis.');
        }

        // Simpan transaksi pembelian
        Penjualan::create([
            'user_id' => Auth::id(),
            'mobil_id' => $mobil->id,
            'harga' => $mobil->harga,
        ]);

        // Kurangi stok mobil
        $mobil->decrement('stok');

        return back()->with('success', 'Berhasil membeli mobil!');
    }
}
