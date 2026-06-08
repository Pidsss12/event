@extends('layouts.app')

@section('title', $event->title . ' - EventHub')

@section('content')
<!-- Event Header Banner -->
<div class="relative bg-slate-900 text-white overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ $event->banner_image }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-16 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
            <!-- Event Title Info -->
            <div class="lg:col-span-8 space-y-4">
                <span class="px-3.5 py-1.5 bg-blue-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider">
                    {{ $event->category->name }}
                </span>
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                    {{ $event->title }}
                </h1>
                
                <!-- Quick Info Bar -->
                <div class="flex flex-wrap gap-6 pt-4 text-sm font-semibold text-slate-300">
                    <div class="flex items-center gap-2">
                        <i data-lucide="calendar" class="w-5 h-5 text-blue-500"></i>
                        {{ $event->date_time->translatedFormat('l, d F Y') }}
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="clock" class="w-5 h-5 text-blue-500"></i>
                        {{ $event->date_time->format('H:i') }} WIB
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-5 h-5 text-blue-500"></i>
                        {{ $event->location }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Grid Body -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Side: Description -->
        <div class="lg:col-span-8 space-y-8">
            <!-- About Event -->
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-xl font-extrabold text-slate-900">Tentang Event Ini</h3>
                <div class="text-slate-600 text-sm leading-relaxed space-y-4 whitespace-pre-line">
                    {{ $event->description }}
                </div>
            </div>

            <!-- Organizer Info -->
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-premium rounded-2xl text-white flex items-center justify-center shadow-lg">
                        <i data-lucide="user" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Diselenggarakan Oleh</span>
                        <h4 class="font-extrabold text-slate-900 text-base">{{ $event->organizer->name }}</h4>
                    </div>
                </div>
                <div class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg">
                    Verified Host
                </div>
            </div>
        </div>

        <!-- Right Side: Booking Widget -->
        <div class="lg:col-span-4">
            <div class="sticky top-28 bg-white border border-slate-100 shadow-xl rounded-3xl p-6 space-y-6">
                <h3 class="text-lg font-extrabold text-slate-900 border-b border-slate-100 pb-3">Pesan Tiket</h3>

                <form action="{{ route('bookings.checkout') }}" method="GET" class="space-y-4" id="booking-widget-form">
                    <!-- Select Ticket Tier -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Kategori Tiket</label>
                        <div class="space-y-2.5">
                            @foreach($event->ticketTypes as $index => $ticket)
                                <label class="border border-slate-200 rounded-2xl p-4 flex items-center justify-between cursor-pointer hover:border-blue-500 hover:bg-blue-50/20 transition relative select-ticket-label">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="ticket_type_id" value="{{ $ticket->id }}" 
                                               data-price="{{ $ticket->price }}" 
                                               data-remaining="{{ $ticket->remaining }}"
                                               {{ $index === 0 ? 'checked' : '' }}
                                               {{ $ticket->remaining <= 0 ? 'disabled' : '' }}
                                               class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                        <div>
                                            <span class="text-sm font-bold text-slate-900 block">{{ $ticket->name }}</span>
                                            <span class="text-xs text-slate-500">Tersisa: {{ $ticket->remaining }} / {{ $ticket->capacity }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($ticket->remaining <= 0)
                                            <span class="px-2 py-1 bg-red-100 text-red-600 text-[10px] font-bold rounded-lg uppercase">Habis</span>
                                        @else
                                            <span class="text-sm font-black text-blue-600">Rp{{ number_format($ticket->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Select Quantity -->
                    <div class="space-y-2">
                        <label for="quantity-input" class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Jumlah Tiket</label>
                        <div class="flex items-center border border-slate-200 rounded-xl w-36 bg-slate-50">
                            <button type="button" id="qty-minus" class="px-3 py-2 text-slate-600 hover:bg-slate-200/50 rounded-l-xl transition font-black">-</button>
                            <input type="number" name="quantity" id="quantity-input" value="1" min="1" max="10" readonly
                                   class="w-full text-center bg-transparent border-0 focus:outline-none focus:ring-0 text-sm font-bold text-slate-800">
                            <button type="button" id="qty-plus" class="px-3 py-2 text-slate-600 hover:bg-slate-200/50 rounded-r-xl transition font-black">+</button>
                        </div>
                    </div>

                    <!-- Total Price Calculation -->
                    <div class="bg-blue-50/70 border border-blue-100 p-4 rounded-2xl flex justify-between items-center">
                        <div>
                            <span class="text-[10px] text-blue-800 font-bold uppercase tracking-wider block">Total Pembayaran</span>
                            <span class="text-xs text-slate-500" id="calculation-desc">Rp0 x 1 tiket</span>
                        </div>
                        <span class="text-lg font-black text-blue-700" id="calculation-total">Rp0</span>
                    </div>

                    <!-- Submit Button -->
                    @auth
                        @if(Auth::user()->isAdmin())
                            <button type="button" disabled class="w-full py-4 bg-slate-200 text-slate-400 rounded-xl font-bold text-sm cursor-not-allowed">
                                Admin Tidak Dapat Membeli
                            </button>
                        @else
                            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-500/20 hover:shadow-blue-500/35 hover:-translate-y-0.5 transition duration-200">
                                Lanjutkan Pembayaran
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-500/20 block transition">
                            Login Untuk Membeli
                        </a>
                    @endauth
                </form>

            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const qtyInput = document.getElementById("quantity-input");
        const qtyPlus = document.getElementById("qty-plus");
        const qtyMinus = document.getElementById("qty-minus");
        
        const priceLabelDesc = document.getElementById("calculation-desc");
        const priceLabelTotal = document.getElementById("calculation-total");
        
        function calculateTotal() {
            const activeRadio = document.querySelector('input[name="ticket_type_id"]:checked');
            if (!activeRadio) return;

            const price = parseFloat(activeRadio.getAttribute('data-price'));
            const remaining = parseInt(activeRadio.getAttribute('data-remaining'));
            const qty = parseInt(qtyInput.value);

            // Update details
            priceLabelDesc.innerText = `Rp${new Intl.NumberFormat('id-ID').format(price)} x ${qty} tiket`;
            priceLabelTotal.innerText = `Rp${new Intl.NumberFormat('id-ID').format(price * qty)}`;
        }

        // Handle Quantity adjustments
        qtyPlus.addEventListener("click", () => {
            const activeRadio = document.querySelector('input[name="ticket_type_id"]:checked');
            const maxRemaining = activeRadio ? parseInt(activeRadio.getAttribute('data-remaining')) : 10;
            const currentVal = parseInt(qtyInput.value);
            
            const limit = Math.min(10, maxRemaining);
            if (currentVal < limit) {
                qtyInput.value = currentVal + 1;
                calculateTotal();
            }
        });

        qtyMinus.addEventListener("click", () => {
            const currentVal = parseInt(qtyInput.value);
            if (currentVal > 1) {
                qtyInput.value = currentVal - 1;
                calculateTotal();
            }
        });

        // Event listeners on ticket selection change
        document.querySelectorAll('input[name="ticket_type_id"]').forEach(radio => {
            radio.addEventListener("change", () => {
                // Adjust label border styling
                document.querySelectorAll('.select-ticket-label').forEach(lbl => {
                    lbl.classList.remove('border-blue-500', 'bg-blue-50/20');
                });
                radio.closest('.select-ticket-label').classList.add('border-blue-500', 'bg-blue-50/20');

                // Reset quantity to 1 to avoid mismatching remaining limits
                qtyInput.value = 1;

                calculateTotal();
            });
        });

        // Initial run
        calculateTotal();
    });
</script>
@endsection
