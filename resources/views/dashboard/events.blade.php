@extends('layouts.dashboard')

@section('title', 'Jelajahi Event - EventHub')
@section('header_title', 'Jelajahi Event')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <!-- Hero Section / Search Filter (Optional but good UX) -->
    <div class="bg-gradient-premium rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1000&auto=format&fit=crop')] bg-cover bg-center opacity-20 mix-blend-overlay"></div>
        <div class="relative z-10 max-w-2xl space-y-4">
            <h2 class="text-3xl font-extrabold font-heading">Temukan Event Menarik</h2>
            <p class="text-blue-100 text-sm leading-relaxed">
                Dari konser musik hingga workshop teknologi, temukan dan pesan tiket event favoritmu langsung dari dashboard.
            </p>
            <div class="pt-4 flex gap-2">
                <div class="relative flex-grow max-w-md">
                    <i data-lucide="search" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400"></i>
                    <input type="text" placeholder="Cari nama event..." class="w-full pl-12 pr-4 py-3 bg-white text-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-md">
                </div>
                <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md transition-colors">
                    Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Event List -->
    <div>
        <div class="flex justify-between items-end mb-6">
            <h3 class="text-xl font-extrabold text-slate-800">Event Mendatang</h3>
            <span class="text-sm font-semibold text-slate-500">{{ $events->count() }} Event Tersedia</span>
        </div>

        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group flex flex-col h-full">
                        <!-- Image Container -->
                        <div class="relative h-48 overflow-hidden shrink-0">
                            <img src="{{ $event->banner_image }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                            
                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold rounded-full shadow-sm">
                                    {{ $event->category->name }}
                                </span>
                            </div>
                        </div>

                        <!-- Content Container -->
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div class="space-y-3 mb-4">
                                <h4 class="font-extrabold text-slate-800 text-lg leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    {{ $event->title }}
                                </h4>
                                
                                <div class="space-y-2 text-xs font-semibold text-slate-500">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="calendar" class="w-4 h-4 text-blue-500 shrink-0"></i>
                                        <span>{{ \Carbon\Carbon::parse($event->date_time)->translatedFormat('l, d F Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="clock" class="w-4 h-4 text-blue-500 shrink-0"></i>
                                        <span>{{ \Carbon\Carbon::parse($event->date_time)->format('H:i') }} WIB</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-rose-500 shrink-0 mt-0.5"></i>
                                        <span class="line-clamp-2 leading-tight">{{ $event->location }}</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('events.show', $event->slug) }}" class="block w-full py-2.5 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white text-center rounded-xl text-sm font-bold transition-colors border border-blue-100 hover:border-transparent mt-auto">
                                Lihat Detail & Pesan Tiket
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl border border-slate-100 p-12 text-center shadow-sm">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="calendar-x" class="w-10 h-10 text-slate-400"></i>
                </div>
                <h3 class="text-lg font-extrabold text-slate-800 mb-2">Belum Ada Event Mendatang</h3>
                <p class="text-slate-500 text-sm max-w-sm mx-auto">Saat ini belum ada event yang dijadwalkan. Silakan cek kembali beberapa saat lagi untuk update event terbaru.</p>
            </div>
        @endif
    </div>
</div>
@endsection
