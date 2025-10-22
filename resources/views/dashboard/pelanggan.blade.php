@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-100 text-slate-800">

    <!-- Sidebar -->
    @include('dashboard.partials.sidebar')

    <!-- Main Content -->
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
        <div class="flex justify-between items-center animate-fade-in-up">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">👥 Manajemen Pelanggan</h2>
                <p class="text-slate-500 mt-1">Kelola daftar pelanggan dan riwayat transaksi mereka.</p>
            </div>
            <div class="relative animate-fade-in-up" style="animation-delay: 0.1s;">
                <input type="text" id="searchInput" placeholder="Cari pelanggan..." 
                    class="bg-slate-100 rounded-full py-2.5 pl-10 pr-4 w-72 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors duration-300">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            </div>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="mt-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg animate-fade-in-up" style="animation-delay: 0.2s;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Daftar Pelanggan -->
        <div id="pelangganContainer" class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse ($pelanggans as $index => $pelanggan)
                <div class="bg-white rounded-2xl shadow-sm p-6 text-center transform hover:-translate-y-1 transition-all duration-300 animate-fade-in-up" style="animation-delay: {{ 0.2 + $index * 0.1 }}s;">
                    <!-- Avatar -->
                    <div class="w-20 h-20 rounded-full mx-auto bg-slate-200 flex items-center justify-center text-2xl font-bold text-slate-500 mb-4">
                        {{ strtoupper(substr($pelanggan->name, 0, 1)) }}
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">{{ $pelanggan->name }}</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ $pelanggan->email }}</p>

                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <p class="text-xs text-slate-400">Total Pembelian</p>
                        <p class="text-xl font-semibold text-blue-600">{{ $pelanggan->total_pembelian }} Unit</p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex gap-3 mt-6">
                        <button class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 py-2 rounded-lg text-sm font-semibold transition" onclick="showDetail({{ $pelanggan->id }})">
                            Detail
                        </button>

                        <form action="{{ route('dashboard.pelanggan.destroy', $pelanggan->id) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                onclick="return confirm('Yakin ingin menghapus pelanggan ini?')"
                                class="w-full bg-red-100 hover:bg-red-200 text-red-700 py-2 rounded-lg text-sm font-semibold transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 animate-fade-in-up">
                    <p class="text-slate-400 text-lg">Belum ada data pelanggan yang terdaftar 😢</p>
                </div>
            @endforelse
        </div>

        <div class="text-xs text-slate-400 mt-8 animate-fade-in-up" style="animation-delay: 0.4s;">
            Menampilkan {{ $pelanggans->count() }} pelanggan terdaftar.
        </div>
    </main>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 z-50 flex justify-center items-center invisible opacity-0 transition-opacity duration-300 ease-out">
    <div class="absolute inset-0 bg-black/40"></div>
    <div id="modalContent" class="bg-white p-6 rounded-2xl w-96 text-slate-700 shadow-xl transform scale-95 opacity-0 transition-all duration-300 ease-out">
        <h2 class="text-xl font-bold mb-4">Detail Pelanggan</h2>
        <div id="detailContent" class="space-y-2">
            <p><strong>Nama:</strong> <span id="detailName"></span></p>
            <p><strong>Email:</strong> <span id="detailEmail"></span></p>
            <p><strong>Jumlah Pembelian:</strong> <span id="detailTotal"></span></p>
        </div>
        <button id="closeModal" class="mt-6 w-full bg-slate-800 text-white py-2 rounded-lg hover:bg-slate-700 transition">
            Tutup
        </button>
    </div>
</div>

<!-- Script Modal & Search -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const detailModal = document.getElementById('detailModal');
    const modalContent = document.getElementById('modalContent');
    const closeModalBtn = document.getElementById('closeModal');
    const searchInput = document.getElementById('searchInput');
    const pelangganContainer = document.getElementById('pelangganContainer');

    // Modal controls
    const openModal = () => {
        detailModal.classList.remove('invisible', 'opacity-0');
        modalContent.classList.remove('scale-95', 'opacity-0');
    };
    const closeModal = () => {
        modalContent.classList.add('scale-95', 'opacity-0');
        detailModal.classList.add('opacity-0');
        setTimeout(() => detailModal.classList.add('invisible'), 300);
    };
    closeModalBtn.addEventListener('click', closeModal);
    detailModal.addEventListener('click', (e) => { if (e.target === detailModal) closeModal(); });

    // 🔍 Fungsi utama search
    let searchTimeout;
    async function doSearch(query) {
        try {
            const res = await fetch(`{{ url('/dashboard/pelanggan/search') }}?q=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!res.ok) throw new Error('Gagal fetch data');
            const data = await res.json();
            pelangganContainer.innerHTML = '';

            if (data.length === 0) {
                pelangganContainer.innerHTML = `
                    <div class="col-span-full text-center py-16">
                        <p class="text-slate-400 text-lg">Tidak ada pelanggan yang cocok 😢</p>
                    </div>`;
                return;
            }

            data.forEach((p, i) => {
                pelangganContainer.insertAdjacentHTML('beforeend', `
                    <div class="bg-white rounded-2xl shadow-sm p-6 text-center transform hover:-translate-y-1 transition-all duration-300 animate-fade-in-up" style="animation-delay: ${0.2 + i * 0.1}s;">
                        <div class="w-20 h-20 rounded-full mx-auto bg-slate-200 flex items-center justify-center text-2xl font-bold text-slate-500 mb-4">
                            ${p.name.charAt(0).toUpperCase()}
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">${p.name}</h3>
                        <p class="text-sm text-slate-500 mt-1">${p.email}</p>
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <p class="text-xs text-slate-400">Total Pembelian</p>
                            <p class="text-xl font-semibold text-blue-600">${p.total_pembelian ?? 0} Unit</p>
                        </div>
                        <div class="flex gap-3 mt-6">
                            <button class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 py-2 rounded-lg text-sm font-semibold transition" onclick="showDetail(${p.id})">Detail</button>
                            <form method="POST" action="/dashboard/pelanggan/${p.id}" class="w-full" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-100 hover:bg-red-200 text-red-700 py-2 rounded-lg text-sm font-semibold transition">Hapus</button>
                            </form>
                        </div>
                    </div>
                `);
            });
        } catch (err) {
            console.error(err);
        }
    }

    // Real-time search + Enter trigger
    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => doSearch(searchInput.value.trim()), 400);
    });

    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            doSearch(searchInput.value.trim());
        }
    });

    // ✳️ Fungsi detail dinamis
    window.showDetail = async function(id) {
        try {
            const res = await fetch(`{{ url('/dashboard/pelanggan') }}/${id}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            document.getElementById('detailName').textContent = data.name;
            document.getElementById('detailEmail').textContent = data.email;
            document.getElementById('detailTotal').textContent = data.penjualan.length + ' Unit';
            openModal();
        } catch (err) {
            console.error('Gagal memuat detail pelanggan:', err);
        }
    };
});
</script>

@endsection
