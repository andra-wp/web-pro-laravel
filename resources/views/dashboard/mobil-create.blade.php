@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-slate-100">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-blue-600">➕ Tambah Mobil Baru</h2>

        <form action="{{ route('dashboard.admin.mobil.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-slate-600 mb-1">Model Mobil</label>
                    <input type="text" name="model" class="w-full border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-slate-600 mb-1">Merek</label>
                    <input type="text" name="merek" class="w-full border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-slate-600 mb-1">Tipe</label>
                    <input type="text" name="tipe" class="w-full border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-slate-600 mb-1">Tahun</label>
                    <input type="number" name="tahun" class="w-full border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-slate-600 mb-1">Harga</label>
                    <input type="number" name="harga" class="w-full border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-slate-600 mb-1">Stok</label>
                    <input type="number" name="stok" class="w-full border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('dashboard.admin.mobil.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg hover:bg-slate-300">
                        Kembali
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
