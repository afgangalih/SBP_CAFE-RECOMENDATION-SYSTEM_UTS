@extends('layouts.user')

@section('title', $title . ' — Ngafein')

@section('content')
<div class="bg-[#FBFBFB] min-h-screen pb-20 relative" x-data="{ openFilter: false }">
    
    <div class="max-w-7xl mx-auto px-4 md:px-8 pt-10 md:pt-16">
        
        <div class="mb-12 relative">
            <x-ui.user-back-button :href="route('user.cafe.index')" class="mb-4" />
            <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight mb-2">{{ $title }}</h1>
            <p class="text-gray-500 font-medium">Menampilkan hasil pencarian berdasarkan kurasi otomatis kami.</p>
        </div>

        <div class="flex lg:hidden items-center justify-between gap-4 mb-8 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mx-1">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Opsi Pencarian</p>
            <button @click="openFilter = true" class="flex items-center justify-center gap-2 bg-gray-900 text-white font-bold px-4 py-2.5 rounded-xl shadow-lg active:scale-95 transition-all">
                <i class="fa-solid fa-sliders text-[10px]"></i>
                <span class="text-[10px]">Filter & Urutkan</span>
            </button>
        </div>

        <div class="flex flex-col lg:grid lg:grid-cols-12 gap-6 md:gap-10">
            
            <aside class="hidden lg:block lg:col-span-3">
                <div class="sticky top-24 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col max-h-[calc(100vh-120px)]">
                    <div class="overflow-y-auto flex-1 pr-2 custom-scrollbar space-y-8">
                        @include('components.ui.user-filter-sidebar')
                    </div>
                    <div class="pt-6 border-t border-gray-50 bg-white">
                        <button class="w-full bg-gray-900 hover:bg-black text-white text-xs font-bold py-4 rounded-2xl transition-all shadow-lg shadow-gray-200 uppercase tracking-widest">
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </aside>

            <div class="col-span-12 lg:col-span-9">
                <div class="hidden lg:flex items-center justify-between mb-8">
                    <p class="text-sm text-gray-400 font-medium">Menampilkan <span class="text-gray-900 font-bold tracking-tight">{{ $cafes->total() }}</span> kafe kurasi</p>
                    
                    <div class="flex items-center gap-4">
                        <div class="h-8 w-[1px] bg-gray-100 mx-2"></div>
                        <select class="bg-transparent text-sm font-bold text-gray-900 focus:outline-none cursor-pointer">
                            <option>Rating Tertinggi</option>
                            <option>Harga Termurah</option>
                            <option>Jarak Terdekat</option>
                        </select>
                    </div>
                </div>

                @if($cafes->isEmpty())
                    <div class="bg-white border border-gray-50 rounded-[40px] p-10 md:p-20 text-center shadow-sm">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8 text-gray-200">
                            <i class="fa-solid fa-mug-hot text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 mb-3">Tidak Ada Hasil</h3>
                        <p class="text-gray-400 max-w-sm mx-auto font-medium text-sm text-center">Coba sesuaikan filter Anda untuk mendapatkan hasil lainnya.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-y-10 sm:gap-6 md:gap-8 overflow-hidden px-1 sm:px-0">
                        @foreach($cafes as $k)
                            @include('components.ui.user-cafe-card', ['k' => $k])
                        @endforeach
                    </div>

                    <div class="mt-16">
                        {{ $cafes->links('components.ui.user-pagination') }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Mobile Filter Drawer (Sama seperti sebelumnya) --}}
    <div x-show="openFilter" ... > 
        {{-- [Isi Drawer yang sama dengan index-cafe sebelumnya] --}}
    </div>
</div>
@endsection
