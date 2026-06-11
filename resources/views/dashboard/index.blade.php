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
            <div class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white shadow-2xl rounded-3xl p-8 space-y-8 relative overflow-hidden transform hover:-translate-y-2 transition duration-500 hover:shadow-blue-900/50">
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-40 h-40 rounded-full bg-white opacity-10 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-32 h-32 rounded-full bg-blue-400 opacity-20 blur-xl"></div>
                
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <span class="text-xs font-bold text-blue-200 uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="wallet" class="w-4 h-4"></i> EventHub Pay
                        </span>
                        <div class="mt-4">
                            <span class="text-[10px] text-blue-300 font-medium uppercase tracking-widest block mb-1">Total Saldo</span>
                            <span class="text-3xl sm:text-4xl font-black tracking-tight">Rp{{ number_format($user->balance, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <!-- Chip icon for card aesthetic -->
                    <div class="w-12 h-10 rounded bg-gradient-to-br from-yellow-200 to-yellow-500 opacity-80 shadow-inner flex items-center justify-center">
                        <div class="w-8 h-6 border border-yellow-700/30 rounded-sm"></div>
                    </div>
                </div>

                <!-- Simulation Top up form -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl relative z-10">
                    <span class="text-[11px] font-bold text-blue-100 uppercase tracking-wider block mb-3 flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i> Isi Saldo Cepat
                    </span>
                    <form action="{{ route('dashboard.topup') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-3 gap-3">
                            <button type="button" onclick="setTopupAmount(100000)" class="py-2.5 bg-white/5 hover:bg-white/20 text-white text-xs font-bold rounded-xl border border-white/10 transition-all shadow-sm">
                                +100k
                            </button>
                            <button type="button" onclick="setTopupAmount(500000)" class="py-2.5 bg-white/5 hover:bg-white/20 text-white text-xs font-bold rounded-xl border border-white/10 transition-all shadow-sm">
                                +500k
                            </button>
                            <button type="button" onclick="setTopupAmount(1000000)" class="py-2.5 bg-white/5 hover:bg-white/20 text-white text-xs font-bold rounded-xl border border-white/10 transition-all shadow-sm">
                                +1M
                            </button>
                        </div>
                        <div class="relative group">
                            <span class="absolute left-4 top-3 text-sm font-bold text-blue-200">Rp</span>
                            <input type="number" name="amount" id="topup-amount-input" min="10000" max="5000000" required
                                   class="w-full pl-10 pr-4 py-3 bg-black/20 border border-white/10 rounded-xl text-sm text-white placeholder-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-black/40 transition-all"
                                   placeholder="Nominal Top-Up">
                        </div>
                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-400 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white rounded-xl text-sm font-extrabold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                            Konfirmasi Top-Up
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
                            <!-- Ticket Card Design -->
                            <div class="relative bg-white border border-slate-200 rounded-2xl flex flex-col md:flex-row shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                                <!-- Left edge decoration -->
                                <div class="absolute left-0 top-0 bottom-0 w-2 {{ $booking->payment_status == 'paid' ? 'bg-blue-500' : 'bg-slate-300' }}"></div>
                                
                                <!-- Main Ticket Content -->
                                <div class="p-6 flex-grow space-y-4 ml-2 border-b md:border-b-0 md:border-r border-dashed border-slate-200 relative">
                                    <!-- Cutout circles for ticket effect -->
                                    <div class="hidden md:block absolute -right-3 -top-3 w-6 h-6 bg-slate-50 rounded-full border border-slate-200"></div>
                                    <div class="hidden md:block absolute -right-3 -bottom-3 w-6 h-6 bg-slate-50 rounded-full border border-slate-200"></div>
                                    
                                    <div class="flex justify-between items-start gap-4">
                                        <div>
                                            <h3 class="font-extrabold text-slate-900 text-lg group-hover:text-blue-600 transition-colors">
                                                {{ $booking->event->title }}
                                            </h3>
                                            <div class="flex items-center gap-2 mt-1 text-slate-500 text-xs font-medium">
                                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                                {{ $booking->event->date_time->translatedFormat('d M Y, H:i') }}
                                            </div>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <span class="text-xs font-black tracking-widest text-slate-400 block mb-1">ID: {{ $booking->booking_code }}</span>
                                            <span class="inline-flex px-2.5 py-1 text-[10px] font-bold rounded-lg uppercase tracking-wider 
                                                {{ $booking->payment_status == 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                                {{ $booking->payment_status }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Ticket Details -->
                                    <div class="bg-slate-50 rounded-xl p-4 grid grid-cols-3 gap-4">
                                        <div>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Kategori</span>
                                            <span class="text-sm font-bold text-slate-800">{{ $booking->ticketType->name }}</span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Jumlah</span>
                                            <span class="text-sm font-bold text-slate-800">{{ $booking->quantity }} Tiket</span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Total</span>
                                            <span class="text-sm font-bold text-blue-600">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Side Actions (Tear-off part) -->
                                <div class="p-6 md:w-48 flex flex-col justify-center gap-3 bg-slate-50/50">
                                    @if($booking->payment_status == 'paid')
                                        <a href="{{ route('bookings.receipt', $booking->booking_code) }}" class="w-full text-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                                            <i data-lucide="download" class="w-4 h-4"></i> E-Ticket
                                        </a>
                                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="delete-confirm">
                                            @csrf
                                            <button type="submit" class="w-full text-center px-4 py-2.5 bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 rounded-xl text-xs font-bold transition">
                                                Batalkan
                                            </button>
                                        </form>
                                    @else
                                        <div class="text-center p-3 rounded-xl border border-slate-200 bg-slate-100 text-slate-400 flex flex-col items-center gap-2">
                                            <i data-lucide="x-circle" class="w-6 h-6"></i>
                                            <span class="text-xs font-bold">Dibatalkan</span>
                                        </div>
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
