<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::where('user_id', Auth::id())->get();
        return view('dashboard.manajemen-mobil', compact('mobils'));
    }

    public function create()
    {
        return view('dashboard.mobil-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'tipe'  => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
            'harga' => 'required|numeric|min:0',
            'stok'  => 'required|integer|min:0',
        ]);

        $validated['user_id'] = Auth::id();
        $mobil = Mobil::create($validated);

        // ✅ Gunakan ajax() & wantsJson()
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Mobil berhasil ditambahkan!',
                'mobil'   => $mobil
            ]);
        }

        // fallback buat form biasa
        return redirect()
            ->route('dashboard.admin.mobil.index')
            ->with('success', 'Mobil berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $mobil = \App\Models\Mobil::findOrFail($id);

        $mobil->stok = $request->stok;
        $mobil->save();

        return response()->json([
            'success' => true,
            'mobil' => $mobil
        ]);
    }


}
