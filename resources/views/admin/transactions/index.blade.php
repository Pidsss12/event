@extends('layouts.dashboard')

@section('title', 'Manajemen Transaksi - Admin')
@section('header_title', 'Semua Transaksi')

@section('styles')
<style>
    .trx-page { min-height: 100%; }

    .page-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 60%, #3b82f6 100%);
        border-radius: 24px;
        padding: 28px 32px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
    }
    .page-header .badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 50px;
        padding: 5px 14px;
        font-size: 12px; font-weight: 700;
        color: white;
    }

    .main-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 24px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .card-head {
        padding: 20px 28px;
        border-bottom: 1px solid #f8fafc;
        display: flex; align-items: center; gap: 12px;
    }
    .card-head-icon {
        width: 40px; height: 40px;
        background: #eff6ff;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
    }

    table { width: 100%; border-collapse: collapse; }
    thead tr { background: #f8fafc; }
    thead th {
        padding: 14px 20px;
        font-size: 11px; font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
    }
    tbody tr { border-bottom: 1px solid #f8fafc; transition: background 0.15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    tbody td { padding: 16px 20px; vertical-align: middle; }

    .user-avatar {
        width: 38px; height: 38px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 800; font-size: 15px;
        flex-shrink: 0;
    }

    .status-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 11px; font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border: 1.5px solid;
    }
    .status-paid   { color: #059669; background: #ecfdf5; border-color: #a7f3d0; }
    .status-pending { color: #d97706; background: #fffbeb; border-color: #fde68a; }
    .status-cancelled { color: #dc2626; background: #fef2f2; border-color: #fecaca; }

    .btn-sm {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 7px 14px;
        border-radius: 10px;
        font-size: 12px; font-weight: 700;
        cursor: pointer;
        border: 1.5px solid;
        transition: all 0.18s;
        text-decoration: none;
    }
    .btn-primary { color: #2563eb; background: #eff6ff; border-color: #bfdbfe; }
    .btn-primary:hover { background: #2563eb; color: white; border-color: #2563eb; }
    .btn-success { color: #059669; background: #ecfdf5; border-color: #a7f3d0; }
    .btn-success:hover { background: #059669; color: white; border-color: #059669; }
    .btn-danger { color: #dc2626; background: #fef2f2; border-color: #fecaca; }
    .btn-danger:hover { background: #dc2626; color: white; border-color: #dc2626; }
    .btn-slate { color: #475569; background: #f8fafc; border-color: #e2e8f0; }
    .btn-slate:hover { background: #e2e8f0; color: #1e293b; border-color: #cbd5e1; }
</style>
@endsection

@section('content')
<div class="trx-page">

    {{-- Header --}}
    <div class="page-header">
        <div style="position:relative; z-index:1;">
            <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; opacity:0.7; margin-bottom:6px;">Admin · Keuangan</p>
            <h1 style="font-size:26px; font-weight:900; margin-bottom:6px; font-family:'Outfit',sans-serif;">Semua Transaksi Tiket</h1>
            <p style="font-size:13px; opacity:0.75; margin-bottom:18px;">Pantau, setujui, atau batalkan seluruh pembelian tiket.</p>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <div class="badge">
                    <i data-lucide="ticket" style="width:13px;height:13px;"></i>
                    Total: {{ $bookings->total() }} Transaksi
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="main-card">
        <div class="card-head">
            <div class="card-head-icon">
                <i data-lucide="receipt" style="width:20px;height:20px;color:#2563eb;"></i>
            </div>
            <div>
                <h2 style="font-size:15px; font-weight:800; color:#0f172a;">Riwayat Transaksi</h2>
                <p style="font-size:12px; color:#94a3b8;">Klik aksi untuk mengubah status booking</p>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th style="text-align:left;">Kode & Waktu</th>
                        <th style="text-align:left;">Pengguna</th>
                        <th style="text-align:left;">Event & Tiket</th>
                        <th style="text-align:right;">Total</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    @php
                        $colors = ['#6366f1','#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6'];
                        $ci = abs(crc32($booking->user->name)) % count($colors);
                        $ac = $colors[$ci];
                    @endphp
                    <tr>
                        <td>
                            <p style="font-size:12px; font-weight:900; color:#1e293b; letter-spacing:0.05em;">{{ $booking->booking_code }}</p>
                            <p style="font-size:11px; color:#94a3b8; margin-top:2px;">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="user-avatar" style="background: linear-gradient(135deg, {{ $ac }}, #a78bfa);">
                                    {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p style="font-size:13px; font-weight:700; color:#0f172a;">{{ $booking->user->name }}</p>
                                    <p style="font-size:11px; color:#94a3b8;">{{ $booking->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p style="font-size:13px; font-weight:700; color:#0f172a; max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $booking->event->title }}</p>
                            <div style="display:flex; gap:6px; margin-top:4px; align-items:center;">
                                <span style="font-size:11px; font-weight:700; color:#2563eb; background:#eff6ff; padding:2px 10px; border-radius:6px;">{{ $booking->ticketType->name }}</span>
                                <span style="font-size:11px; color:#94a3b8;">x{{ $booking->quantity }}</span>
                            </div>
                        </td>
                        <td style="text-align:right;">
                            <p style="font-size:14px; font-weight:900; color:#0f172a;">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            <p style="font-size:10px; color:#94a3b8; text-transform:uppercase; margin-top:2px;">{{ $booking->payment_method ?? 'wallet' }}</p>
                        </td>
                        <td style="text-align:center;">
                            @if($booking->payment_status == 'paid')
                                <span class="status-pill status-paid">
                                    <i data-lucide="check-circle" style="width:11px;height:11px;"></i> Paid
                                </span>
                            @elseif($booking->payment_status == 'pending')
                                <span class="status-pill status-pending">
                                    <i data-lucide="clock" style="width:11px;height:11px;"></i> Pending
                                </span>
                            @else
                                <span class="status-pill status-cancelled">
                                    <i data-lucide="x-circle" style="width:11px;height:11px;"></i> Batal
                                </span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex; justify-content:center; gap:6px; flex-wrap:wrap;">
                                @if($booking->proof_of_payment)
                                    <a href="{{ asset('storage/' . $booking->proof_of_payment) }}" target="_blank" class="btn-sm btn-slate">
                                        <i data-lucide="image" style="width:12px;height:12px;"></i> Bukti
                                    </a>
                                @endif
                                <a href="{{ route('bookings.receipt', $booking->booking_code) }}" target="_blank" class="btn-sm btn-primary">
                                    <i data-lucide="eye" style="width:12px;height:12px;"></i> Tiket
                                </a>
                                @if($booking->payment_status == 'pending')
                                    <form action="{{ route('admin.transactions.approve', $booking->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-sm btn-success">
                                            <i data-lucide="check" style="width:12px;height:12px;"></i> Terima
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.transactions.cancel', $booking->id) }}" method="POST" class="delete-confirm" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-sm btn-danger">
                                            <i data-lucide="x" style="width:12px;height:12px;"></i> Tolak
                                        </button>
                                    </form>
                                @elseif($booking->payment_status == 'paid')
                                    <form action="{{ route('admin.transactions.cancel', $booking->id) }}" method="POST" class="delete-confirm" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-sm btn-danger">
                                            <i data-lucide="ban" style="width:12px;height:12px;"></i> Batalkan
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size:12px; color:#94a3b8; font-style:italic;">Selesai</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:64px 20px; text-align:center;">
                            <div style="display:flex;flex-direction:column;align-items:center;gap:12px;">
                                <div style="width:64px;height:64px;background:#f8fafc;border-radius:20px;border:2px dashed #e2e8f0;display:flex;align-items:center;justify-content:center;">
                                    <i data-lucide="inbox" style="width:28px;height:28px;color:#cbd5e1;"></i>
                                </div>
                                <p style="font-size:14px;font-weight:700;color:#64748b;">Belum ada transaksi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
        <div style="padding: 20px 28px; border-top: 1px solid #f8fafc;">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
