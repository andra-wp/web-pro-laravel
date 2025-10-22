@props(['icon', 'color', 'title', 'value'])

<div class="bg-white p-6 rounded-2xl shadow-sm transition-transform hover:scale-105 animate-fade-in-up">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-slate-500">{{ $title }}</h3>
            <p class="text-3xl font-bold text-{{ $color }}-600 mt-2">{{ $value }}</p>
        </div>
        <div class="bg-{{ $color }}-100 text-{{ $color }}-600 p-3 rounded-full text-xl">
            <i class="{{ $icon }}"></i>
        </div>
    </div>
</div>
