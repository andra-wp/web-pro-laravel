@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100 flex flex-col items-center justify-center py-16 px-6">
    <div class="bg-white shadow-lg rounded-2xl w-full max-w-3xl p-8 animate-fade-in-up">
        <h2 class="text-3xl font-bold text-slate-800 mb-2 text-center">👤 Profil Akun</h2>
        <p class="text-slate-500 text-center mb-8">Lihat dan kelola informasi akun Anda.</p>

        <!-- 📋 Informasi User -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-slate-50 p-5 rounded-xl shadow-sm">
                <h3 class="text-slate-500 text-sm">Nama Lengkap</h3>
                <p class="text-lg font-semibold text-slate-800 mt-1">{{ Auth::user()->name }}</p>
            </div>
            <div class="bg-slate-50 p-5 rounded-xl shadow-sm">
                <h3 class="text-slate-500 text-sm">Email</h3>
                <p class="text-lg font-semibold text-slate-800 mt-1">{{ Auth::user()->email }}</p>
            </div>
            <div class="bg-slate-50 p-5 rounded-xl shadow-sm">
                <h3 class="text-slate-500 text-sm">Role</h3>
                <p class="text-lg font-semibold text-slate-800 mt-1 capitalize">{{ Auth::user()->role }}</p>
            </div>
            <div class="bg-slate-50 p-5 rounded-xl shadow-sm">
                <h3 class="text-slate-500 text-sm">Tanggal Bergabung</h3>
                <p class="text-lg font-semibold text-slate-800 mt-1">
                    {{ Auth::user()->created_at->format('d M Y') }}
                </p>
            </div>
        </div>

        <!-- 📝 Form Edit Profil -->
        <h3 class="text-xl font-semibold text-slate-700 mb-4">Ubah Profil</h3>
        <form method="POST" action="{{ route('dashboard.profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Nama -->
            <div>
                <label class="block text-slate-600 text-sm mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                    class="w-full border border-slate-300 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-slate-600 text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                    class="w-full border border-slate-300 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <!-- Password baru -->
            <div>
                <label class="block text-slate-600 text-sm mb-1">Password Baru (Opsional)</label>
                <input type="password" name="password"
                    class="w-full border border-slate-300 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <!-- Konfirmasi password baru -->
            <div>
                <label class="block text-slate-600 text-sm mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation"
                    class="w-full border border-slate-300 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <!-- Tombol Simpan -->
            <div class="text-right">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 font-semibold transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>


        <!-- 🚪 Tombol Logout -->
        <div class="mt-10 text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-red-500 font-medium hover:text-red-700 transition">
                    Logout dari Akun
                </button>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out forwards;
}
</style>
@endsection
