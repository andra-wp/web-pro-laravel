@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-100 text-slate-800">
    @include('dashboard.partials.sidebar')

    <main class="flex-1 p-10 overflow-y-auto">
        <style>
            @keyframes fade-in-up {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in-up {
                animation: fade-in-up 0.5s ease-out forwards;
                opacity: 0;
            }
        </style>

        <!-- Header -->
        <div class="animate-fade-in-up">
            <h2 class="text-3xl font-bold text-slate-800">📈 Laporan Penjualan</h2>
            <p class="text-slate-500 mt-1">Ringkasan performa penjualan mobil Anda.</p>
        </div>

        <!-- Kartu Metrik Utama -->
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm hover:-translate-y-1 transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.1s;">
                <h3 class="text-slate-500">Total Pendapatan</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm hover:-translate-y-1 transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.2s;">
                <h3 class="text-slate-500">Mobil Terjual</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalMobil }} Unit</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm hover:-translate-y-1 transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.3s;">
                <h3 class="text-slate-500">Transaksi Rata-rata</h3>
                <p class="text-3xl font-bold text-yellow-600 mt-2">
                    Rp {{ number_format($rataTransaksi, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="mt-12 animate-fade-in-up text-center text-slate-600" style="animation-delay: 0.4s;">
            <p class="text-lg">📊 Laporan ringkas penjualan saat ini.</p>
            <p class="text-sm text-slate-400 mt-2">Gunakan halaman ini untuk memantau performa penjualan tanpa detail bulanan.</p>
        </div>
    </main>
</div>
@endsection
