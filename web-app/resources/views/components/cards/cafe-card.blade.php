@php
    $thumb = $k->gambar->first()?->link_gambar
        ?? 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&q=80&w=800';
    $hargaMin = number_format($k->harga_min, 0, ',', '.');
    $fasilitasUnggulan = $k->fasilitas->take(3);
    $fasIcons = [
        'wifi' => 'fa-wifi', 'colokan' => 'fa-plug', 'parkir' => 'fa-square-p',
        'toilet' => 'fa-restroom', 'mushola' => 'fa-mosque', 'indoor' => 'fa-house-user',
        'outdoor' => 'fa-sun', 'workspace' => 'fa-laptop-code', 'live_music' => 'fa-music',
    ];
@endphp

<a href="{{ route('user.cafe.detail', $k->id_kafe) }}"
   class="group relative bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full">

    <div class="relative h-48 overflow-hidden bg-gray-100">
        <img src="{{ $thumb }}" alt="{{ $k->nama_kafe }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>

        <div class="absolute top-3 left-3 flex items-center gap-1.5 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-full shadow-sm">
            <i class="fa-solid fa-star text-[#b87c39] text-xs"></i>
            <span class="text-xs font-bold text-gray-800">{{ number_format($k->rating, 1) }}</span>
        </div>

        <div class="absolute bottom-3 left-3 right-3 flex items-center gap-1.5 flex-wrap">
            @foreach($fasilitasUnggulan as $fas)
            @php $fKey = strtolower($fas->nama_fasilitas); @endphp
            <span class="bg-black/40 backdrop-blur-sm text-white text-[9px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1">
                <i class="fa-solid {{ $fasIcons[$fKey] ?? 'fa-check' }} text-[8px]"></i>
                {{ ucfirst(str_replace('_', ' ', $fas->nama_fasilitas)) }}
            </span>
            @endforeach
        </div>
    </div>

    <div class="p-4 flex flex-col flex-1">
        <div class="flex items-start justify-between gap-2 mb-2">
            <h3 class="font-bold text-gray-900 text-sm leading-tight group-hover:text-[#b87c39] transition-colors line-clamp-2">
                {{ $k->nama_kafe }}
            </h3>
            @if($k->menus->first())
            <span class="shrink-0 text-[9px] font-bold bg-[#b87c39]/10 text-[#b87c39] px-2 py-0.5 rounded-full uppercase tracking-tighter">
                {{ $k->menus->first()->nama_menu }}
            </span>
            @endif
        </div>

        <div class="flex items-center gap-1.5 text-gray-400 text-[11px] mb-4">
            <i class="fa-solid fa-location-dot text-[#b87c39] text-[10px]"></i>
            <span>{{ $k->jarak }} km dari lokasi Anda</span>
        </div>

        <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between">
            <div>
                <p class="text-[9px] text-gray-400 font-medium uppercase mb-0.5">Mulai dari</p>
                <p class="text-sm font-extrabold text-gray-900">Rp {{ $hargaMin }}</p>
            </div>
            <span class="flex items-center gap-1.5 text-[11px] font-bold text-[#b87c39] bg-[#b87c39]/5 px-3 py-2 rounded-xl group-hover:bg-[#b87c39] group-hover:text-white transition-all">
                Detail <i class="fa-solid fa-arrow-right text-[9px]"></i>
            </span>
        </div>
    </div>
</a>
