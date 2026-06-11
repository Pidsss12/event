@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - EventHub')
@section('header_title', 'Dashboard Admin')

@section('styles')
<style>
    .admin-page-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #2563eb 100%);
        border-radius: 24px;
        padding: 28px 32px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
    }
    .admin-page-header::before {
        content: '';
        position: absolute;
        top: -50px; right: -60px;
        width: 220px; height: 220px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }
    .admin-page-header::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 25%;
        width: 150px; height: 150px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .admin-page-header .hdr-btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 12px; font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
    }
    .hdr-btn-outline {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.25);
        color: white;
    }
    .hdr-btn-outline:hover { background: rgba(255,255,255,0.2); }
    .hdr-btn-solid {
        background: white;
        color: #1d4ed8;
        border: none;
        box-shadow: 0 4px 12px rgba(255,255,255,0.15);
    }
    .hdr-btn-solid:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(255,255,255,0.2); }

    .pending-topup-banner {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border: 1.5px solid #f59e0b;
        border-radius: 16px;
        padding: 14px 20px;
        display: flex; align-items: center; justify-content: space-between; gap: 16px;
        margin-bottom: 24px;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 space-y-8">

    {{-- Premium Header --}}
    <div class="admin-page-header">
        <div style="position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
            <div>
                <span style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; opacity:0.7; display:block; margin-bottom:6px;">Admin Area</span>
                <h1 style="font-size:26px; font-weight:900; margin-bottom:4px; font-family:'Outfit',sans-serif;">Analitik Platform</h1>
                <p style="font-size:13px; opacity:0.75;">Pantau performa platform EventHub secara real-time.</p>
            </div>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('admin.categories.index') }}" class="hdr-btn hdr-btn-outline">
                    <i data-lucide="tag" style="width:14px;height:14px;"></i> Kategori
                </a>
                <a href="{{ route('admin.events.create') }}" class="hdr-btn hdr-btn-solid">
                    <i data-lucide="plus-circle" style="width:14px;height:14px;"></i> Buat Event Baru
                </a>
            </div>
        </div>
    </div>

    {{-- Pending Top-Up Banner --}}
    <div class="pending-topup-banner">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:40px; height:40px; background:#f59e0b; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i data-lucide="banknote" style="width:20px;height:20px;color:white;"></i>
            </div>
            <div>
                <p style="font-size:13px; font-weight:800; color:#92400e;">Permintaan Top‑Up Menunggu Persetujuan</p>
                <p style="font-size:12px; color:#b45309;">Tinjau bukti pembayaran dan setujui saldo pengguna.</p>
            </div>
        </div>
        <a href="{{ route('admin.topups') }}" style="display:inline-flex; align-items:center; gap:6px; padding:10px 18px; background:#f59e0b; color:white; border-radius:12px; font-size:12px; font-weight:800; text-decoration:none; flex-shrink:0; transition:all 0.2s; box-shadow:0 4px 12px rgba(245,158,11,0.3);">
            <i data-lucide="arrow-right" style="width:14px;height:14px;"></i>
            Lihat Sekarang
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat Card 1 -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white p-6 rounded-3xl shadow-lg flex items-center gap-4 transform hover:-translate-y-1 transition duration-300">
            <div class="p-3.5 bg-white/20 backdrop-blur-sm rounded-2xl">
                <i data-lucide="calendar" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-[10px] text-blue-100 font-bold uppercase tracking-wider block">Total Event</span>
                <span class="text-xl sm:text-3xl font-black">{{ $totalEvents }}</span>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-gradient-to-br from-emerald-400 to-emerald-600 text-white p-6 rounded-3xl shadow-lg flex items-center gap-4 transform hover:-translate-y-1 transition duration-300">
            <div class="p-3.5 bg-white/20 backdrop-blur-sm rounded-2xl">
                <i data-lucide="ticket" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-[10px] text-emerald-100 font-bold uppercase tracking-wider block">Total Booking</span>
                <span class="text-xl sm:text-3xl font-black">{{ $totalBookings }}</span>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-700 text-white p-6 rounded-3xl shadow-lg flex items-center gap-4 transform hover:-translate-y-1 transition duration-300">
            <div class="p-3.5 bg-white/20 backdrop-blur-sm rounded-2xl">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-[10px] text-purple-100 font-bold uppercase tracking-wider block">Total User</span>
                <span class="text-xl sm:text-3xl font-black">{{ $totalUsers }}</span>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-gradient-to-br from-amber-400 to-amber-600 text-white p-6 rounded-3xl shadow-lg flex items-center gap-4 transform hover:-translate-y-1 transition duration-300">
            <div class="p-3.5 bg-white/20 backdrop-blur-sm rounded-2xl">
                <i data-lucide="dollar-sign" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-[10px] text-amber-100 font-bold uppercase tracking-wider block">Total Transaksi</span>
                <span class="text-xl sm:text-2xl font-black">Rp{{ number_format($totalSales, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.topups') }}" class="mt-6 inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">Pending Top‑Up Requests</a>
<!-- Analytics Chart -->
    <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-6 sm:p-8 space-y-6">
        <h3 class="text-lg font-extrabold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-4">
            <i data-lucide="bar-chart-2" class="w-5 h-5 text-blue-600"></i> Tren Penjualan 7 Hari Terakhir
        </h3>
        <div class="relative h-72 w-full">
            <canvas id="salesChart"></canvas>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mock data for sales chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Gradient for line chart
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)'); // blue-500
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: [1500000, 2300000, 1800000, 3200000, 2900000, 4500000, 5100000],
                    borderColor: '#3b82f6',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { size: 13, family: "'Plus Jakarta Sans', sans-serif" },
                        bodyFont: { size: 14, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif" }, color: '#64748b' }
                    },
                    y: {
                        grid: { color: '#f1f5f9', borderDash: [5, 5], drawBorder: false },
                        ticks: {
                            font: { family: "'Plus Jakarta Sans', sans-serif" },
                            color: '#64748b',
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000) + ' Jt';
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
            }
        });
    });
</script>
@endsection
