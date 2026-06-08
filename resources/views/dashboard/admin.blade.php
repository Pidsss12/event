@extends('layouts.admin')

@section('title', 'Admin Dashboard - EventHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    
    <!-- Header Summary -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block">Admin Area</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">Analitik Platform</h1>
        </div>
        <!-- Actions buttons -->
        <div class="flex gap-2">
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs flex items-center gap-2 shadow-sm transition">
                <i data-lucide="tag" class="w-4 h-4"></i> Kelola Kategori
            </a>
            <a href="{{ route('admin.events.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs flex items-center gap-2 shadow-lg shadow-blue-500/20 transition">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Buat Event Baru
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat Card 1 -->
        <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-sm flex items-center gap-4">
            <div class="p-3.5 bg-blue-50 text-blue-600 rounded-2xl">
                <i data-lucide="calendar" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Total Event</span>
                <span class="text-xl sm:text-2xl font-black text-slate-800">{{ $totalEvents }}</span>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-sm flex items-center gap-4">
            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-2xl">
                <i data-lucide="ticket" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Total Booking</span>
                <span class="text-xl sm:text-2xl font-black text-slate-800">{{ $totalBookings }}</span>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-sm flex items-center gap-4">
            <div class="p-3.5 bg-purple-50 text-purple-600 rounded-2xl">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Total User</span>
                <span class="text-xl sm:text-2xl font-black text-slate-800">{{ $totalUsers }}</span>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-sm flex items-center gap-4">
            <div class="p-3.5 bg-amber-50 text-amber-600 rounded-2xl">
                <i data-lucide="dollar-sign" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Total Transaksi</span>
                <span class="text-xl sm:text-2xl font-black text-slate-800">Rp{{ number_format($totalSales, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-6 sm:p-8 space-y-6">
        <h3 class="text-lg font-extrabold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-4">
            <i data-lucide="history" class="w-5 h-5 text-blue-600"></i> Transaksi Tiket Terbaru
        </h3>

        @if($recentBookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-slate-600 text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="pb-3 pr-4">Kode Booking</th>
                            <th class="pb-3 px-4">Nama Pelanggan</th>
                            <th class="pb-3 px-4">Event</th>
                            <th class="pb-3 px-4">Kategori Tiket</th>
                            <th class="pb-3 px-4">Total</th>
                            <th class="pb-3 px-4 text-center">Status</th>
                            <th class="pb-3 pl-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $bk)
                            <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50 transition">
                                <td class="py-4 pr-4 font-bold text-slate-900">{{ $bk->booking_code }}</td>
                                <td class="py-4 px-4 font-semibold">{{ $bk->user->name }}</td>
                                <td class="py-4 px-4 font-semibold text-slate-800 max-w-xs truncate">{{ $bk->event->title }}</td>
                                <td class="py-4 px-4">{{ $bk->ticketType->name }} (x{{ $bk->quantity }})</td>
                                <td class="py-4 px-4 font-bold text-blue-600">Rp{{ number_format($bk->total_price, 0, ',', '.') }}</td>
                                <td class="py-4 px-4 text-center">
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg uppercase tracking-wider 
                                        {{ $bk->payment_status == 'paid' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' }}">
                                        {{ $bk->payment_status }}
                                    </span>
                                </td>
                                <td class="py-4 pl-4">
                                    @if($bk->payment_status == 'paid')
                                        <a href="{{ route('bookings.receipt', $bk->booking_code) }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white rounded-lg text-xs font-bold transition">
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16 bg-slate-50 rounded-2xl space-y-3">
                <i data-lucide="ticket-x" class="w-8 h-8 text-slate-400 mx-auto"></i>
                <p class="text-sm font-semibold text-slate-500">Belum ada transaksi pemesanan tiket pada platform.</p>
            </div>
        @endif
    </div>

</div>
@endsection
