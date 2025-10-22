@extends('layouts.app')

@section('content')
<style>
    /* Mengaktifkan smooth scrolling dan scroll snapping */
    html, body {
        height: 100%;
        overflow: hidden; /* Mencegah scroll di body */
    }
    main {
        height: 100vh;
        overflow-y: scroll;
        scroll-snap-type: y mandatory;
        scroll-behavior: smooth; 
    }
    .content-section {
        scroll-snap-align: start;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center; /* Memusatkan konten secara horizontal */
        padding: 4rem 2rem; 
    }
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        opacity: 0;
        animation: fade-in 0.5s ease-out forwards;
    }
    .animate-fade-in-up {
        opacity: 0;
        animation: fade-in-up 0.5s ease-out forwards;
    }
    /* Style untuk link navbar yang aktif */
    .nav-link.active {
        color: #2563eb; /* text-blue-600 */
        font-weight: 600; /* font-semibold */
    }
</style>

<!-- 🌐 Navbar -->
<nav class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 animate-fade-in-up">
    <div class="bg-white/90 backdrop-blur-md shadow-lg border border-gray-100 rounded-full px-8 py-3 flex items-center space-x-8">
        <a href="#dashboard" class="nav-link text-gray-700 hover:text-blue-600 transition">
            Dashboard
        </a>
        <a href="#riwayat" class="nav-link text-gray-700 hover:text-blue-600 transition">
            Riwayat
        </a>
        <a href="#mobil" class="nav-link text-gray-700 hover:text-blue-600 transition">
            Marketplace
        </a>
        <a href="{{ route('dashboard.profile') }}" class="text-gray-700 hover:text-blue-600 transition">
            Profile
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-500 font-medium hover:text-red-700 transition">
                Logout
            </button>
        </form>
    </div>
</nav>

<!-- 🧭 Konten Utama -->
<main class="bg-slate-50">
    @if (session('success'))
    <div id="flashMessage" class="fixed inset-0 flex items-center justify-center z-50 bg-black/40 backdrop-blur-sm animate-fade-in">
        <div class="bg-white rounded-2xl shadow-2xl px-10 py-8 text-center relative max-w-md w-full animate-popup border border-gray-100">
            <!-- ✅ Animasi Centang -->
            <div class="flex justify-center mb-6">
                <div class="checkmark-container">
                    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                        <path class="checkmark-check" fill="none" d="M14 27l7 7 17-17"/>
                    </svg>
                </div>
            </div>

            <!-- 📝 Pesan -->
            <h2 class="text-2xl font-semibold text-green-700 mb-2">Berhasil!</h2>
            <p class="text-gray-600 mb-6">{{ session('success') }}</p>

            <!-- 🔘 Tombol OK -->
            <button id="okButton" 
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium shadow-md">
                OK
            </button>
        </div>
    </div>

    <!-- 🎨 Style Animasi -->
    <style>
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes fade-out {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    @keyframes popup {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .animate-popup {
        animation: popup 0.4s ease-out forwards;
    }

    /* Centang Animasi */
    .checkmark {
        width: 72px;
        height: 72px;
        stroke-width: 3;
        stroke: #16a34a; /* Tailwind green-600 */
        stroke-miterlimit: 10;
        display: block;
        border-radius: 50%;
    }
    .checkmark-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 3;
        stroke-miterlimit: 10;
        stroke: #16a34a;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.4s cubic-bezier(0.65, 0, 0.45, 1) 0.6s forwards;
    }
    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }
    </style>

    <!-- 🧠 Script Tutup Notifikasi -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const flash = document.getElementById('flashMessage');
        const okBtn = document.getElementById('okButton');

        // Tutup otomatis setelah 4 detik
        setTimeout(() => {
            if (flash) {
                flash.style.animation = 'fade-out 0.5s ease-out forwards';
                setTimeout(() => flash.remove(), 500);
            }
        }, 4000);

        // Tutup manual dengan tombol OK
        okBtn.addEventListener('click', () => {
            flash.style.animation = 'fade-out 0.4s ease-out forwards';
            setTimeout(() => flash.remove(), 400);
        });
    });
    </script>
    @endif


    <!-- Section 1: Dashboard -->
    <section id="dashboard" class="content-section">
        <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Kolom Konten -->
            <div class="animate-fade-in-up" style="animation-delay: 0.1s;">
                <h1 class="text-5xl font-bold text-slate-800 mb-2">Dashboard Anda</h1>
                <p class="text-gray-500 text-lg">Selamat datang kembali, {{ $user->name }}!</p>
                <div class="space-y-6 mt-10">
                     <div class="bg-white p-6 rounded-2xl shadow-sm text-left flex items-center gap-6">
                        <div class="bg-blue-100 text-blue-600 p-4 rounded-xl">
                            <i class="fas fa-car fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-600">Total Mobil Dibeli</h3>
                            <p class="text-3xl font-bold text-blue-600">{{ $totalMobilDibeli }}</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm text-left flex items-center gap-6">
                        <div class="bg-green-100 text-green-600 p-4 rounded-xl">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-600">Total Pengeluaran</h3>
                            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm text-left flex items-center gap-6">
                        <div class="bg-yellow-100 text-yellow-600 p-4 rounded-xl">
                            <i class="fas fa-star fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-600">Poin Reward</h3>
                            <p class="text-3xl font-bold text-yellow-600">{{ $poinReward }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kolom Desain -->
            <div class="hidden lg:flex justify-center items-center animate-fade-in-up relative h-full" style="animation-delay: 0.3s;">
                <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-blue-200 rounded-full opacity-50 blur-3xl"></div>
                <div class="absolute -top-24 -left-24 w-80 h-80 bg-green-200 rounded-full opacity-50 blur-3xl"></div>
                <div class="relative bg-white/50 backdrop-blur-md p-8 rounded-3xl shadow-lg border border-white/20">
                    <svg class="w-64 h-64 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Riwayat Pembelian -->
    <section id="riwayat" class="content-section bg-white">
        <div class="max-w-4xl mx-auto w-full">
            <div class="text-center mb-10 animate-fade-in-up">
                <h2 class="text-4xl font-bold text-slate-800">Riwayat Transaksi</h2>
                <p class="text-gray-500 mt-2">Semua pembelian Anda tercatat di sini.</p>
            </div>
            <div class="w-full bg-slate-50 rounded-2xl p-6 shadow-inner animate-fade-in-up" style="animation-delay: 0.2s;">
                @if ($penjualans->count() > 0)
                    <div class="max-h-[55vh] overflow-y-auto space-y-4 pr-2"> <!-- pr-2 untuk ruang scrollbar -->
                        @foreach ($penjualans as $index => $p)
                            <div class="bg-white hover:shadow-md rounded-xl p-4 flex items-center justify-between transition shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="bg-blue-50 p-3 rounded-lg">
                                        <i class="fas fa-receipt text-blue-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $p->mobil->model ?? 'Tidak Diketahui' }}</p>
                                        <p class="text-sm text-slate-500">{{ $p->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <p class="font-semibold text-green-600">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10">
                        <p class="text-gray-500">Belum ada transaksi pembelian 😢</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Section 3: Mobil Tersedia -->
    <section id="mobil" class="content-section bg-slate-50">
        <div class="max-w-7xl mx-auto w-full">
            <div class="text-center mb-10 animate-fade-in-up">
                <h2 class="text-4xl font-bold text-slate-800">Marketplace Mobil</h2>
                <p class="text-gray-500 mt-2">Temukan mobil impian Anda di sini.</p>
            </div>
            @if ($mobils->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($mobils as $index => $mobil)
                        <div class="bg-white shadow-sm rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-300 animate-fade-in-up" style="animation-delay: {{ 0.1 + $index * 0.1 }}s;">
                            <img src="https://placehold.co/600x400/e2e8f0/334155?text={{ urlencode($mobil->model) }}" 
                                 alt="{{ $mobil->model }}" class="w-full h-48 object-cover">
                            <div class="p-5">
                                <h3 class="text-lg font-bold text-gray-800">{{ $mobil->model }}</h3>
                                <p class="text-gray-500 mt-1">{{ $mobil->merek }} - {{ $mobil->tipe }}</p>
                                <p class="text-blue-600 font-bold text-xl mt-3">
                                    Rp {{ number_format($mobil->harga, 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-gray-400 mt-1">Stok: {{ $mobil->stok }}</p>
                                <form method="POST" action="{{ route('dashboard.user.beli', $mobil->id) }}">
                                    @csrf
                                    <button class="mt-4 w-full bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 transition font-semibold">
                                        Beli Sekarang
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 animate-fade-in-up">
                    <p class="text-gray-500">Belum ada mobil tersedia 😢</p>
                </div>
            @endif
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const mainContainer = document.querySelector('main');
    const sections = document.querySelectorAll('.content-section');
    const navLinks = document.querySelectorAll('.nav-link');

    if (navLinks.length > 0) {
        navLinks[0].classList.add('active');
    }
    
    const observerOptions = {
        root: mainContainer,
        rootMargin: '0px',
        threshold: 0.5 // 50% of the section must be visible
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${id}`) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(section => {
        observer.observe(section);
    });
});
</script>
@endsection

