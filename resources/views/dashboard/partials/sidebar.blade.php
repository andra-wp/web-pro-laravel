<aside class="w-64 flex-shrink-0 bg-white shadow-lg p-6 flex flex-col justify-between">
    <div>
        <div class="flex items-center gap-3 mb-10">
            <span class="text-3xl text-blue-600"><i class="fas fa-car-side"></i></span>
            <h1 class="text-xl font-bold text-slate-800">Admin Mobil</h1>
        </div>

        <nav class="flex flex-col gap-3">
            <!-- Dashboard -->
            <a href="{{ route('dashboard.admin') }}" 
               class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-200
               {{ request()->routeIs('dashboard.admin') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-200' }}">
                <i class="fas fa-tachometer-alt w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            <!-- Manajemen Mobil -->
            <a href="{{ route('dashboard.mobil') }}" 
               class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-200
               {{ request()->routeIs('dashboard.mobil') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-200' }}">
                <i class="fas fa-car w-5 text-center"></i>
                <span>Manajemen Mobil</span>
            </a>

            <!-- Pelanggan -->
            <a href="{{ route('dashboard.pelanggan') }}" 
               class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-200
               {{ request()->routeIs('dashboard.pelanggan') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-200' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Pelanggan</span>
            </a>

            <!-- Laporan -->
            <a href="{{ route('dashboard.laporan') }}" 
               class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-200
               {{ request()->routeIs('dashboard.laporan') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-200' }}">
                <i class="fas fa-chart-line w-5 text-center"></i>
                <span>Laporan</span>
            </a>
        </nav>
    </div>

    <div class="border-t border-slate-200 pt-4">
        <a href="{{ route('dashboard.profile') }}" 
           class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-200 transition">
            <i class="fas fa-user-cog w-5 text-center"></i>
            <span>Profile</span>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" 
                class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-red-500 hover:bg-red-100 transition">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
