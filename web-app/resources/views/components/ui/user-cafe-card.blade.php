@php
    $thumb = $k->gambar->first()?->link_gambar
        ?? 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&q=80&w=800';
    $hargaMin = number_format($k->harga_min, 0, ',', '.');
    
    // Mapping Fasilitas untuk Hover State
    $hasWifi = $k->fasilitas->contains(fn($f) => str_contains(strtolower($f->nama_fasilitas), 'wifi'));
    $hasPlug = $k->fasilitas->contains(fn($f) => str_contains(strtolower($f->nama_fasilitas), 'colokan'));
    $hasAC = $k->fasilitas->contains(fn($f) => str_contains(strtolower($f->nama_fasilitas), 'ac'));
@endphp

<a href="{{ route('user.cafe.detail', $k->id_kafe) }}"
   class="group relative block aspect-[4/5] rounded-[2.5rem] overflow-hidden shadow-2xl hover:shadow-[#b87c39]/20 transition-all duration-500 bg-gray-900">
    
    {{-- Background Image --}}
    <img src="{{ $thumb }}" alt="{{ $k->nama_kafe }}"
         class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
    
    {{-- Dark Gradient Overlay (Normal State) --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-40 transition-opacity duration-500"></div>

    {{-- Top Badge --}}
    <div class="absolute top-6 left-6">
        <div class="bg-black/40 backdrop-blur-md border border-white/20 text-white px-4 py-2 rounded-2xl flex items-center gap-2">
            <i class="fa-solid fa-mug-hot text-[10px]"></i>
            <span class="text-[10px] font-bold uppercase tracking-widest">Cafe</span>
        </div>
    </div>

    {{-- Bottom Info (Normal State) --}}
    <div class="absolute bottom-8 left-8 right-8 group-hover:translate-y-10 group-hover:opacity-0 transition-all duration-500">
        <div class="mb-4">
            <h3 class="text-2xl font-black text-white leading-tight mb-2 tracking-tight">
                {{ $k->nama_kafe }}
            </h3>
            <div class="flex items-center gap-2 text-white/70 text-xs font-medium">
                <i class="fa-solid fa-location-dot text-[#b87c39]"></i>
                <span>Malang, Indonesia</span>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex flex-col">
                <div class="flex items-center gap-1 mb-1">
                    <span class="text-lg font-black text-white">{{ number_format($k->rating, 1) }}</span>
                    <div class="flex text-[10px] text-amber-400">
                        @for($i = 0; $i < 5; $i++)
                            <i class="fa-solid fa-star {{ $i < round($k->rating) ? '' : 'text-gray-600' }}"></i>
                        @endfor
                    </div>
                </div>
                <span class="text-[9px] font-bold text-white/40 uppercase tracking-widest">Really Good</span>
            </div>
            <div class="text-right">
                <span class="block text-lg font-black text-white">Rp {{ $hargaMin }}</span>
                <span class="text-[9px] font-bold text-white/40 uppercase tracking-widest">Starting price</span>
            </div>
        </div>
    </div>

    {{-- Hover Detail State (Glassmorphism) --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500 p-10 flex flex-col justify-center">
        <div class="space-y-8">
            <div class="flex items-center justify-between group/item">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white border border-white/10">
                        <i class="fa-solid fa-wifi text-sm"></i>
                    </div>
                    <span class="text-sm font-bold text-white tracking-wide">Internet Speed</span>
                </div>
                <span class="px-3 py-1 bg-black/40 rounded-lg text-[10px] font-black text-white border border-white/10 uppercase tracking-widest">
                    {{ $hasWifi ? 'Fast' : 'N/A' }}
                </span>
            </div>

            <div class="flex items-center justify-between group/item">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white border border-white/10">
                        <i class="fa-solid fa-plug text-sm"></i>
                    </div>
                    <span class="text-sm font-bold text-white tracking-wide">Power Outlets</span>
                </div>
                <span class="px-3 py-1 bg-black/40 rounded-lg text-[10px] font-black text-white border border-white/10 uppercase tracking-widest">
                    {{ $hasPlug ? 'Enough' : 'Limited' }}
                </span>
            </div>

            <div class="flex items-center justify-between group/item">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white border border-white/10">
                        <i class="fa-solid fa-couch text-sm"></i>
                    </div>
                    <span class="text-sm font-bold text-white tracking-wide">Seating Comfort</span>
                </div>
                <span class="px-3 py-1 bg-black/40 rounded-lg text-[10px] font-black text-white border border-white/10 uppercase tracking-widest">
                    {{ $hasAC ? 'Comfortable' : 'Standard' }}
                </span>
            </div>

            <div class="pt-10">
                <button class="w-full bg-white text-black font-black py-4 rounded-2xl text-xs uppercase tracking-[0.2em] shadow-xl hover:scale-105 transition-transform">
                    View Details
                </button>
            </div>
        </div>
    </div>
</a>
