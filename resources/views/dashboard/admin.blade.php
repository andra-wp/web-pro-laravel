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
                animation: fade-in-up 0.6s ease-out forwards;
                opacity: 0;
            }
        </style>

        <!-- 👋 Greeting -->
        <div class="animate-fade-in-up">
            <h2 class="text-4xl font-bold text-slate-800">
                Selamat Datang Kembali, {{ Auth::user()->name }}!
            </h2>
            <p class="text-slate-500 mt-2">
                Ini adalah ringkasan performa penjualan mobil Anda.
            </p>
        </div>

        <!-- 📊 Statistik Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-10">
            <x-dashboard-card 
                icon="fas fa-check-circle" 
                color="blue" 
                title="Total Mobil Terjual" 
                :value="$totalTerjual"
            />
            <x-dashboard-card 
                icon="fas fa-wallet" 
                color="green" 
                title="Total Pendapatan" 
                :value="'Rp ' . number_format($totalPendapatan, 0, ',', '.')"
            />
            <x-dashboard-card 
                icon="fas fa-car-side" 
                color="yellow" 
                title="Mobil Tersedia" 
                :value="$totalMobilTersedia"
            />
            <x-dashboard-card 
                icon="fas fa-user-friends" 
                color="purple" 
                title="Total Pelanggan" 
                :value="$totalPelanggan"
            />
        </div>

        <!-- 📈 Penjualan Terbaru -->
        <div class="bg-white p-8 rounded-2xl shadow-sm mt-10 animate-fade-in-up">
            <h3 class="text-xl font-semibold text-slate-700 mb-4">Penjualan Terbaru</h3>

            @forelse($penjualanTerbaru as $jual)
                <div class="flex items-center justify-between border-b border-slate-100 py-3">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-car text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-700">{{ $jual->mobil->model }}</p>
                            <p class="text-sm text-slate-500">{{ $jual->user->name }}</p>
                        </div>
                    </div>
                    <p class="font-semibold text-green-600">
                        +Rp {{ number_format($jual->harga, 0, ',', '.') }}
                    </p>
                </div>
            @empty
                <p class="text-slate-500">Belum ada penjualan.</p>
            @endforelse
        </div>
    </main>
</div>
@endsection
