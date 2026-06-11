@extends('layouts.app')

@section('title', 'Tiket Digital Anda - ' . $booking->booking_code)

@section('styles')
<style>
    @media print {
        nav, footer, .no-print {
            display: none !important;
        }
        body {
            background-color: white;
            padding: 0;
            margin: 0;
        }
        .print-card {
            border: 2px solid #e2e8f0 !important;
            box-shadow: none !important;
            max-width: 100% !important;
            margin: 0 !important;
        }
    }
    .barcode-line {
        background-color: #0f172a;
        height: 50px;
    }
</style>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <!-- Success Banner (No Print) -->
    <!-- Success Banner (No Print) -->
    @if($booking->payment_status == 'paid')
        <div class="no-print bg-emerald-50 border border-emerald-200 text-emerald-800 p-6 rounded-3xl shadow-sm mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500 text-white rounded-xl">
                    <i data-lucide="check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-base">Pembayaran Berhasil!</h3>
                    <p class="text-xs text-emerald-600">Tiket digital resmi Anda telah diterbitkan.</p>
                </div>
            </div>
    @elseif($booking->payment_status == 'pending')
        <div class="no-print bg-amber-50 border border-amber-200 text-amber-800 p-6 rounded-3xl shadow-sm mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-500 text-white rounded-xl">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-base">Menunggu Verifikasi Admin!</h3>
                    <p class="text-xs text-amber-600">Bukti pembayaran Anda sedang dicek. Tiket belum aktif.</p>
                </div>
            </div>
    @else
        <div class="no-print bg-rose-50 border border-rose-200 text-rose-800 p-6 rounded-3xl shadow-sm mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-rose-500 text-white rounded-xl">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-base">Transaksi Dibatalkan</h3>
                    <p class="text-xs text-rose-600">Pemesanan ini telah dibatalkan.</p>
                </div>
            </div>
    @endif
        <div class="flex gap-3">
            <a href="{{ route('bookings.download', $booking->booking_code) }}" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs flex items-center gap-2 shadow-sm transition">
                <i data-lucide="download" class="w-4 h-4"></i> Download Tiket
            </a>
            <a href="{{ route('dashboard') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs transition">
                Dashboard Saya
            </a>
        </div>
    </div>

    <!-- Ticket Card (Printable) -->
    <div class="print-card bg-white rounded-3xl border-2 border-slate-200 shadow-xl overflow-hidden relative">
        
        <!-- Blue Ticket Accent Top -->
        <div class="h-4 bg-gradient-premium"></div>

        <!-- Ticket Body -->
        <div class="p-8 space-y-8">
            
            <!-- Logo & Title -->
            <div class="flex justify-between items-start border-b border-dashed border-slate-200 pb-6">
                <div>
                    <span class="text-2xl font-extrabold tracking-tight text-slate-900">Event<span class="text-blue-600">Hub</span></span>
                    <span class="text-[10px] text-slate-400 block font-bold mt-0.5">E-TICKET RESMI</span>
                </div>
                @if($booking->payment_status == 'paid')
                    <div class="bg-blue-50 text-blue-700 px-4 py-1.5 rounded-xl text-xs font-black uppercase tracking-wider">
                        Paid
                    </div>
                @elseif($booking->payment_status == 'pending')
                    <div class="bg-amber-50 text-amber-700 px-4 py-1.5 rounded-xl text-xs font-black uppercase tracking-wider">
                        Pending
                    </div>
                @else
                    <div class="bg-rose-50 text-rose-700 px-4 py-1.5 rounded-xl text-xs font-black uppercase tracking-wider">
                        Cancelled
                    </div>
                @endif
            </div>

            <!-- Event Details -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                <!-- Banner Image -->
                <div class="md:col-span-4 aspect-video md:aspect-square rounded-2xl overflow-hidden shadow-sm">
                    @php
                        // Encode image to base64 to prevent html2canvas CORS issues
                        try {
                            $imageData = base64_encode(file_get_contents($booking->event->banner_image));
                            $src = 'data:image/jpeg;base64,'.$imageData;
                        } catch (\Exception $e) {
                            $src = $booking->event->banner_image; // Fallback
                        }
                    @endphp
                    <img src="{{ $src }}" alt="{{ $booking->event->title }}" class="w-full h-full object-cover">
                </div>
                <!-- Details -->
                <div class="md:col-span-8 space-y-3">
                    <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-lg uppercase">
                        {{ $booking->event->category->name }}
                    </span>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-snug">{{ $booking->event->title }}</h2>
                    <p class="text-xs text-slate-500 font-bold flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-500"></i>
                        {{ $booking->event->location }}
                    </p>
                </div>
            </div>

            <!-- Date, Time, Seat Class -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 bg-slate-50 border border-slate-100 p-6 rounded-2xl">
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Tanggal</span>
                    <span class="text-sm font-extrabold text-slate-800">{{ $booking->event->date_time->translatedFormat('d F Y') }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Waktu</span>
                    <span class="text-sm font-extrabold text-slate-800">{{ $booking->event->date_time->format('H:i') }} WIB</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Kelas Tiket</span>
                    <span class="text-sm font-extrabold text-blue-600">{{ $booking->ticketType->name }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Jumlah</span>
                    <span class="text-sm font-extrabold text-slate-800">{{ $booking->quantity }} Orang</span>
                </div>
            </div>

            <!-- Holder Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-dashed border-slate-200 pt-6">
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Nama Pemegang Tiket</span>
                    <h4 class="text-sm font-extrabold text-slate-800">{{ $booking->user->name }}</h4>
                    <p class="text-xs text-slate-500">{{ $booking->user->email }}</p>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Metode & Waktu Bayar</span>
                    <h4 class="text-sm font-extrabold text-slate-800">{{ $booking->payment_method ?: 'Wallet EventHub' }}</h4>
                    <p class="text-xs text-slate-500">{{ $booking->booked_at->translatedFormat('d F Y | H:i') }} WIB</p>
                </div>
            </div>

            <!-- Barcode Section (Stunning CSS layout) -->
            <div class="border-t border-slate-200 pt-8 flex flex-col items-center justify-center space-y-3">
                <span class="text-2xl font-black tracking-widest text-slate-800 uppercase" id="booking-code-text">
                    {{ $booking->booking_code }}
                </span>
                
                <!-- Mock Barcode bars -->
                <div class="flex items-center gap-[2px] w-72">
                    <div class="barcode-line w-[4px]"></div>
                    <div class="barcode-line w-[2px]"></div>
                    <div class="barcode-line w-[6px]"></div>
                    <div class="barcode-line w-[1px]"></div>
                    <div class="barcode-line w-[4px]"></div>
                    <div class="barcode-line w-[2px]"></div>
                    <div class="barcode-line w-[8px]"></div>
                    <div class="barcode-line w-[1px]"></div>
                    <div class="barcode-line w-[3px]"></div>
                    <div class="barcode-line w-[5px]"></div>
                    <div class="barcode-line w-[2px]"></div>
                    <div class="barcode-line w-[6px]"></div>
                    <div class="barcode-line w-[4px]"></div>
                    <div class="barcode-line w-[1px]"></div>
                    <div class="barcode-line w-[8px]"></div>
                    <div class="barcode-line w-[2px]"></div>
                    <div class="barcode-line w-[3px]"></div>
                    <div class="barcode-line w-[1px]"></div>
                    <div class="barcode-line w-[5px]"></div>
                    <div class="barcode-line w-[6px]"></div>
                    <div class="barcode-line w-[2px]"></div>
                    <div class="barcode-line w-[4px]"></div>
                    <div class="barcode-line w-[8px]"></div>
                    <div class="barcode-line w-[1px]"></div>
                    <div class="barcode-line w-[3px]"></div>
                </div>
                
                <span class="text-[10px] text-slate-400 font-bold tracking-widest uppercase">
                    Pindai tiket ini saat memasuki gerbang acara.
                </span>
            </div>

        </div>
        
        <!-- Blue Ticket Accent Bottom -->
        <div class="h-2 bg-gradient-premium"></div>
    </div>
</div>
@endsection
