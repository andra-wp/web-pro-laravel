<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = User::where('role', 'user')
            ->withCount(['penjualan as total_pembelian'])
            ->get();

        return view('dashboard.pelanggan', compact('pelanggans'));
    }

    public function show($id)
    {
        $pelanggan = User::with('penjualan')->findOrFail($id);
        return response()->json($pelanggan);
    }

    public function destroy($id)
    {
        $pelanggan = User::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('dashboard.pelanggan')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }

        public function search(Request $request)
    {
        $keyword = $request->input('q');
        
        $pelanggans = \App\Models\User::where('role', 'user')
            ->where(function($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            })
            ->withCount(['penjualan as total_pembelian'])
            ->get();

        return response()->json($pelanggans);
    }

}
