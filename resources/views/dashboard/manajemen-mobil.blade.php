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
            #toast {
                position: fixed;
                top: 20px;
                right: 20px;
                background: #10B981;
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                font-weight: 500;
                box-shadow: 0 4px 10px rgba(0,0,0,0.2);
                opacity: 0;
                transform: translateY(-10px);
                transition: opacity 0.3s ease, transform 0.3s ease;
                z-index: 100;
            }
            #toast.show {
                opacity: 1;
                transform: translateY(0);
            }
        </style>

        <div id="toast"></div>

        <!-- Header -->
        <div class="flex justify-between items-center animate-fade-in-up">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Manajemen Mobil</h2>
                <p class="text-slate-500 mt-1">Kelola daftar mobil di garasi atau showroom Anda.</p>
            </div>
            <button id="add-car-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition-colors flex items-center gap-2 shadow-md">
                <i class="fas fa-plus"></i>
                <span>Tambah Mobil</span>
            </button>
        </div>

        <!-- Daftar Mobil -->
        <div id="mobil-list" class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($mobils as $mobil)
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden transform hover:-translate-y-1 transition-all duration-300 animate-fade-in-up relative group">
                    <img src="https://placehold.co/600x400/e2e8f0/334155?text={{ urlencode($mobil->model) }}" 
                        alt="{{ $mobil->model }}" class="w-full h-48 object-cover">

                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs text-slate-500">{{ $mobil->merek }}</p>
                                <h3 class="text-xl font-bold text-slate-800 mt-1">{{ $mobil->model }}</h3>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">{{ $mobil->tipe }}</span>
                        </div>

                        <p class="text-2xl font-bold text-green-600 mt-4">Rp {{ number_format($mobil->harga, 0, ',', '.') }}</p>

                        <div class="flex justify-between text-sm text-slate-500 mt-4 pt-4 border-t border-slate-100">
                            <span><i class="fas fa-calendar-alt mr-1"></i> {{ $mobil->tahun }}</span>
                            <span><i class="fas fa-box mr-1"></i> 
                                <span id="stok-{{ $mobil->id }}">{{ $mobil->stok }}</span> Unit
                            </span>
                        </div>

                        <button 
                            class="absolute top-3 right-3 bg-blue-600 text-white px-3 py-1 text-xs rounded-lg opacity-0 group-hover:opacity-100 transition"
                            onclick="openEditModal({{ $mobil->id }}, '{{ $mobil->model }}', {{ $mobil->stok }})">
                            <i class="fas fa-pen"></i> Edit
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <!-- Modal Tambah Mobil -->
    <div id="add-car-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-8 modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-slate-800">Tambah Mobil Baru</h3>
                <button id="close-modal-btn" class="text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
            </div>
            <form id="addCarForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-600 mb-1">Model Mobil</label>
                        <input type="text" name="model" class="w-full border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Merek</label>
                        <input type="text" name="merek" class="w-full border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Tipe</label>
                        <input type="text" name="tipe" class="w-full border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Tahun</label>
                        <input type="number" name="tahun" class="w-full border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Stok</label>
                        <input type="number" name="stok" class="w-full border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-600 mb-1">Harga</label>
                        <input type="number" name="harga" class="w-full border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>
                <div class="flex justify-end gap-4 mt-8">
                    <button type="button" id="cancel-btn" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg font-semibold transition">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Stok Mobil -->
    <div id="edit-car-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-slate-800">Edit Stok Mobil</h3>
                <button id="close-edit-btn" class="text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
            </div>
            <form id="editCarForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editCarId">
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-600 mb-1">Model</label>
                    <input type="text" id="editCarModel" class="w-full border border-slate-300 rounded-lg p-2.5 bg-slate-100 text-slate-500" disabled>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Stok</label>
                    <input type="number" id="editCarStock" name="stok" class="w-full border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex justify-end gap-4 mt-8">
                    <button type="button" id="cancel-edit-btn" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg font-semibold transition">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const addCarBtn = document.getElementById('add-car-btn');
    const addCarModal = document.getElementById('add-car-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const addCarForm = document.getElementById('addCarForm');
    const mobilList = document.getElementById('mobil-list');
    const toast = document.getElementById('toast');

    // 🔥 Bikin showToast global (biar bisa dipanggil di luar DOMContentLoaded)
    window.showToast = (msg, color = '#10B981') => {
        toast.style.background = color;
        toast.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    };

    const openModal = () => addCarModal.classList.remove('hidden');
    const closeModal = () => addCarModal.classList.add('hidden');

    addCarBtn.addEventListener('click', openModal);
    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    // 🧱 Tambah Mobil
    addCarForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(addCarForm);
        try {
            const response = await fetch("{{ route('dashboard.admin.mobil.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (response.ok) {
                const data = await response.json();
                if (data.success) {
                    addCarForm.reset();
                    closeModal();
                    showToast('✅ Mobil berhasil ditambahkan!');
                    location.reload();
                } else {
                    showToast(data.message || '⚠️ Gagal menambah mobil.', '#f59e0b');
                }
            } else {
                const errorText = await response.text();
                console.error('Server response:', errorText);
                showToast('💥 Terjadi kesalahan server.', '#ef4444');
            }
        } catch (error) {
            console.error('Fetch error:', error);
            showToast('💥 Terjadi kesalahan server.', '#ef4444');
        }
    });

});

// ✏️ EDIT MOBIL
const editModal = document.getElementById('edit-car-modal');
const closeEditBtn = document.getElementById('close-edit-btn');
const cancelEditBtn = document.getElementById('cancel-edit-btn');
const editCarForm = document.getElementById('editCarForm');
const editCarId = document.getElementById('editCarId');
const editCarModel = document.getElementById('editCarModel');
const editCarStock = document.getElementById('editCarStock');

window.openEditModal = (id, model, stok) => {
    editCarId.value = id;
    editCarModel.value = model;
    editCarStock.value = stok;
    editModal.classList.remove('hidden');
};

const closeEditModal = () => editModal.classList.add('hidden');
closeEditBtn.addEventListener('click', closeEditModal);
cancelEditBtn.addEventListener('click', closeEditModal);

editCarForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = editCarId.value;
    const stok = editCarStock.value;

    try {
        const response = await fetch(`{{ url('dashboard/admin/mobil') }}/${id}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ stok })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            document.getElementById(`stok-${id}`).textContent = data.mobil.stok;
            closeEditModal();
            showToast('✅ Stok berhasil diperbarui!');
        } else {
            showToast('⚠️ Gagal memperbarui stok.', '#f59e0b');
        }
    } catch {
        showToast('💥 Terjadi kesalahan server.', '#ef4444');
    }
});

editModal.addEventListener('click', (e) => {
    if (e.target === editModal) closeEditModal();
});
</script>

</div>
@endsection
