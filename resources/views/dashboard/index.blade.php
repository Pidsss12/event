@extends('layouts.dashboard')

@section('title', 'Dashboard Saya - EventHub')
@section('header_title', 'Dompet & Tiket')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: User Profile & Top-Up Wallet (Span 4) -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Profile Info card -->
            <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-6 text-center space-y-4">
                <div class="w-20 h-20 bg-gradient-premium rounded-full text-white flex items-center justify-center shadow-lg mx-auto">
                    <i data-lucide="user" class="w-10 h-10"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-lg leading-tight">{{ $user->name }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $user->email }}</p>
                </div>
                <div class="inline-flex px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold uppercase tracking-wider">
                    Customer Account
                </div>
            </div>

            <!-- Wallet / Balance Card -->
            <div class="bg-gradient-premium text-white shadow-xl rounded-3xl p-6 space-y-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-cover bg-center opacity-10" style="background-image: url('https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=600&auto=format&fit=crop');"></div>
                <div class="relative z-10 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-blue-200 uppercase tracking-widest">Dompet Digital</span>
                        <i data-lucide="wallet" class="w-5 h-5 text-blue-200"></i>
                    </div>
                    <div>
                        <span class="text-[10px] text-blue-200 font-bold uppercase tracking-wider block">Saldo Tersedia</span>
                        <span class="text-2xl sm:text-3xl font-black">Rp{{ number_format($user->balance, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Simulation Top up form -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-4 rounded-2xl relative z-10 space-y-3">
                    <span class="text-xs font-bold text-white uppercase tracking-wider block">Isi Saldo (Simulasi)</span>
                    <form action="{{ route('dashboard.topup') }}" method="POST" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-3 gap-2">
                            <button type="button" onclick="setTopupAmount(100000)" class="py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-bold rounded-lg border border-white/10 transition">
                                +100k
                            </button>
                            <button type="button" onclick="setTopupAmount(500000)" class="py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-bold rounded-lg border border-white/10 transition">
                                +500k
                            </button>
                            <button type="button" onclick="setTopupAmount(1000000)" class="py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-bold rounded-lg border border-white/10 transition">
                                +1M
                            </button>
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-xs font-bold text-blue-200">Rp</span>
                            <input type="number" name="amount" id="topup-amount-input" min="10000" max="5000000" required
                                   class="w-full pl-8 pr-3 py-2 bg-white/15 border border-white/25 rounded-xl text-xs text-white placeholder-blue-300 focus:outline-none focus:ring-2 focus:ring-white focus:bg-white/20"
                                   placeholder="Jumlah Top-Up (min. 10.000)">
                        </div>
                        <button type="submit" class="w-full py-2 bg-white text-blue-900 rounded-xl text-xs font-bold shadow-md hover:bg-blue-50 transition">
                            Isi Saldo
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Booking History (Span 8) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-6 sm:p-8 space-y-6">
                <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                    <h2 class="text-xl font-extrabold text-slate-800 flex items-center gap-2">
                        <i data-lucide="ticket" class="w-5 h-5 text-blue-600"></i> Riwayat Pemesanan Tiket
                    </h2>
                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg">
                        {{ $bookings->count() }} Transaksi
                    </span>
                </div>

                @if($bookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                            <div class="border border-slate-100 rounded-2xl p-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:border-slate-200 transition">
                                <div class="space-y-3">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-xs font-black tracking-wider text-slate-900">
                                            {{ $booking->booking_code }}
                                        </span>
                                        <span class="px-2 py-0.5 text-[9px] font-bold rounded-md uppercase tracking-wider 
                                            {{ $booking->payment_status == 'paid' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' }}">
                                            {{ $booking->payment_status }}
                                        </span>
                                    </div>
                                    <h3 class="font-extrabold text-slate-800 text-sm leading-snug">
                                        {{ $booking->event->title }}
                                    </h3>
                                    <div class="grid grid-cols-2 sm:flex sm:flex-wrap gap-x-4 gap-y-1 text-slate-400 text-xs font-semibold">
                                        <span class="flex items-center gap-1"><i data-lucide="tag" class="w-3.5 h-3.5 text-blue-500"></i> {{ $booking->ticketType->name }}</span>
                                        <span class="flex items-center gap-1"><i data-lucide="users" class="w-3.5 h-3.5 text-blue-500"></i> x{{ $booking->quantity }} Tiket</span>
                                        <span class="flex items-center gap-1"><i data-lucide="dollar-sign" class="w-3.5 h-3.5 text-blue-500"></i> Rp{{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                
                                <!-- Booking Actions -->
                                <div class="flex gap-2 w-full md:w-auto border-t md:border-t-0 pt-3 md:pt-0">
                                    @if($booking->payment_status == 'paid')
                                        <a href="{{ route('bookings.receipt', $booking->booking_code) }}" class="flex-grow md:flex-grow-0 text-center px-4 py-2.5 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white rounded-xl text-xs font-bold transition">
                                            Lihat Tiket
                                        </a>
                                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="flex-grow md:flex-grow-0 delete-confirm">
                                            @csrf
                                            <button type="submit" class="w-full text-center px-4 py-2.5 bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 rounded-xl text-xs font-bold transition">
                                                Batalkan
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full md:w-auto text-center px-4 py-2.5 bg-slate-100 text-slate-400 rounded-xl text-xs font-bold cursor-not-allowed">
                                            Dibatalkan & Direfund
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16 bg-slate-50 rounded-2xl space-y-4">
                        <div class="p-4 bg-blue-50 text-blue-600 rounded-full w-fit mx-auto">
                            <i data-lucide="ticket" class="w-10 h-10"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-800 text-base">Belum Ada Pemesanan Tiket</h3>
                        <p class="text-slate-500 text-xs max-w-xs mx-auto leading-relaxed">Anda belum membeli tiket untuk event apa pun. Mulai cari event menarik!</p>
                        <a href="{{ route('home') }}" class="inline-block px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition">
                            Cari Event Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function setTopupAmount(amount) {
        document.getElementById('topup-amount-input').value = amount;
    }
</script>
@endsection
