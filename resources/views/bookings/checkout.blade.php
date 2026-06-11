@extends('layouts.app')

@section('title', 'Checkout Pembayaran - EventHub')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
        
        <!-- Header -->
        <div class="p-8 bg-slate-900 text-white flex justify-between items-center">
            <div>
                <span class="text-[10px] text-blue-400 font-extrabold uppercase tracking-widest block">Checkout Tiket</span>
                <h2 class="text-xl sm:text-2xl font-extrabold">Konfirmasi Pembayaran</h2>
            </div>
            <i data-lucide="shield-check" class="w-10 h-10 text-emerald-400"></i>
        </div>

        <div class="p-8 space-y-8">
            <!-- Order Summary Card -->
            <div class="bg-slate-50 border border-slate-200/60 p-6 rounded-2xl grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <div class="md:col-span-2 space-y-3">
                    <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-lg uppercase">
                        {{ $ticketType->event->category->name }}
                    </span>
                    <h3 class="font-extrabold text-slate-800 text-base leading-snug">{{ $ticketType->event->title }}</h3>
                    <p class="text-xs text-slate-400 font-bold flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-500"></i>
                        {{ $ticketType->event->location }}
                    </p>
                </div>
                <div class="bg-white border border-slate-200/50 p-4 rounded-xl text-center shadow-sm">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Kategori Tiket</span>
                    <span class="text-sm font-extrabold text-slate-800 block mt-1">{{ $ticketType->name }}</span>
                    <span class="text-xs text-slate-500 mt-0.5 block">Jumlah: {{ $quantity }} tiket</span>
                </div>
            </div>

            <!-- Billing Details -->
            <div class="space-y-4">
                <h4 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider border-b border-slate-100 pb-2">Rincian Tagihan</h4>
                
                <div class="space-y-2.5 text-sm">
                    <div class="flex justify-between font-semibold text-slate-600">
                        <span>Harga Tiket ({{ $ticketType->name }})</span>
                        <span>Rp{{ number_format($ticketType->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-slate-600">
                        <span>Jumlah Pembelian</span>
                        <span>x{{ $quantity }}</span>
                    </div>
                    <div class="border-t border-slate-100 my-2 pt-2.5 flex justify-between items-center">
                        <span class="font-bold text-slate-800">Total Pembayaran</span>
                        <span class="text-xl font-black text-blue-600">Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Wallet status check -->
            @php
                $user = Auth::user();
                $hasBalance = $user->balance >= $totalPrice;
                $remBalance = $user->balance - $totalPrice;
            @endphp

            <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="ticket_type_id" value="{{ $ticketType->id }}">
                <input type="hidden" name="quantity" value="{{ $quantity }}">

                <!-- Select Payment Method -->
                <div class="space-y-3">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Metode Pembayaran</label>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- EventHub Wallet option -->
                        <label class="border rounded-2xl p-5 flex items-start gap-3.5 cursor-pointer transition relative {{ $hasBalance ? 'border-blue-500 bg-blue-50/20' : 'border-slate-200 bg-slate-50/40 opacity-70' }}">
                            <input type="radio" name="payment_method" value="Wallet EventHub" checked {{ !$hasBalance ? 'disabled' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                            <div class="space-y-1">
                                <span class="text-sm font-bold text-slate-900 block flex items-center gap-1.5">
                                    <i data-lucide="wallet" class="w-4 h-4 text-blue-600"></i> Dompet EventHub
                                </span>
                                <span class="text-xs text-slate-500 block">Saldo Anda: Rp{{ number_format($user->balance, 0, ',', '.') }}</span>
                                @if($hasBalance)
                                    <span class="text-[10px] text-emerald-600 font-bold block mt-1.5">Sisa Saldo Setelah Transaksi: Rp{{ number_format($remBalance, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-[10px] text-rose-500 font-bold block mt-1.5">Saldo tidak cukup. Silakan top-up di dashboard Anda.</span>
                                @endif
                            </div>
                        </label>

                        <!-- Simulated Bank Transfer option -->
                        <label class="border rounded-2xl p-5 flex items-start gap-3.5 cursor-pointer transition relative border-slate-200 bg-white hover:border-blue-400 payment-option">
                            <input type="radio" name="payment_method" value="Transfer Bank"
                                   class="mt-1 w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500" onchange="toggleProofUpload()">
                            <div class="space-y-1">
                                <span class="text-sm font-bold text-slate-900 block flex items-center gap-1.5">
                                    <i data-lucide="building" class="w-4 h-4 text-slate-500"></i> Transfer Bank
                                </span>
                                <span class="text-[10px] text-slate-500 block">BCA, Mandiri, BNI, BRI</span>
                            </div>
                        </label>

                        <!-- E-Wallet option -->
                        <label class="border rounded-2xl p-5 flex items-start gap-3.5 cursor-pointer transition relative border-slate-200 bg-white hover:border-blue-400 payment-option">
                            <input type="radio" name="payment_method" value="E-Wallet"
                                   class="mt-1 w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500" onchange="toggleProofUpload()">
                            <div class="space-y-1">
                                <span class="text-sm font-bold text-slate-900 block flex items-center gap-1.5">
                                    <i data-lucide="smartphone" class="w-4 h-4 text-slate-500"></i> E-Wallet
                                </span>
                                <span class="text-[10px] text-slate-500 block">GoPay, OVO, Dana, ShopeePay</span>
                            </div>
                        </label>

                        <!-- Minimarket option -->
                        <label class="border rounded-2xl p-5 flex items-start gap-3.5 cursor-pointer transition relative border-slate-200 bg-white hover:border-blue-400 payment-option">
                            <input type="radio" name="payment_method" value="Minimarket"
                                   class="mt-1 w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500" onchange="toggleProofUpload()">
                            <div class="space-y-1">
                                <span class="text-sm font-bold text-slate-900 block flex items-center gap-1.5">
                                    <i data-lucide="store" class="w-4 h-4 text-slate-500"></i> Minimarket
                                </span>
                                <span class="text-[10px] text-slate-500 block">Indomaret, Alfamart, Alfamidi</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Proof of Payment Upload Section (Hidden for EventHub Pay) -->
                <div id="proof-upload-section" class="hidden space-y-3 bg-slate-50 p-5 rounded-2xl border border-slate-200">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Unggah Bukti Pembayaran</label>
                    <p class="text-xs text-slate-500">Silakan lakukan pembayaran sebesar <strong class="text-slate-800">Rp{{ number_format($totalPrice, 0, ',', '.') }}</strong> dan unggah foto/screenshot struk bukti transfer (Format: JPG, PNG).</p>
                    
                    <input type="file" name="proof_of_payment" id="proof_of_payment" accept=".jpg,.jpeg,.png"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition border border-slate-200 rounded-xl bg-white cursor-pointer">
                    
                    @error('proof_of_payment')
                        <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-slate-100">
                    <a href="{{ route('events.show', $ticketType->event->slug) }}" class="w-full sm:w-1/3 text-center py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-bold transition">
                        Batal
                    </a>
                    
                    @if($hasBalance)
                        <button type="submit" class="w-full sm:w-2/3 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/20 hover:-translate-y-0.5 transition duration-200">
                            Bayar Sekarang (Konfirmasi)
                        </button>
                    @else
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-2/3 text-center py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20 hover:-translate-y-0.5 transition duration-200">
                            Top-Up Saldo Dompet
                        </a>
                    @endif
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function toggleProofUpload() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const proofSection = document.getElementById('proof-upload-section');
        const proofInput = document.getElementById('proof_of_payment');
        
        if (selectedMethod === 'Wallet EventHub') {
            proofSection.classList.add('hidden');
            proofInput.removeAttribute('required');
            proofInput.disabled = true;
        } else {
            proofSection.classList.remove('hidden');
            proofInput.setAttribute('required', 'required');
            proofInput.disabled = false;
        }
    }

    // Initialize state on load
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener to EventHub Pay radio explicitly since it was not in the chunk
        const ehPayRadio = document.querySelector('input[value="Wallet EventHub"]');
        if (ehPayRadio) {
            ehPayRadio.addEventListener('change', toggleProofUpload);
        }
        toggleProofUpload();
    });
</script>
@endsection
