@extends('layouts.dashboard')

@section('title', 'Permintaan Top-Up - Admin')
@section('header_title', 'Permintaan Top‑Up')

@section('styles')
<style>
    .topup-page { background: #f8fafc; min-height: 100%; }

    .page-header {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a78bfa 100%);
        border-radius: 24px;
        padding: 32px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .page-header::after {
        content: '';
        position: absolute;
        bottom: -60px; left: 30%;
        width: 160px; height: 160px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }
    .page-header .badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 12px; font-weight: 700;
        color: white;
    }

    /* Cards */
    .topup-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 16px;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .topup-card:hover {
        box-shadow: 0 8px 32px rgba(99,102,241,0.12);
        transform: translateY(-2px);
    }
    .topup-card .card-body {
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    /* Avatar */
    .user-avatar {
        width: 48px; height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 800; font-size: 18px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(99,102,241,0.3);
    }

    /* Amount */
    .amount-badge {
        font-size: 20px; font-weight: 900;
        color: #059669;
        letter-spacing: -0.5px;
    }

    /* Method pill */
    .method-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px; font-weight: 700;
        border: 1.5px solid;
    }

    /* Date */
    .date-text { font-size: 13px; color: #64748b; font-weight: 600; }
    .date-sub  { font-size: 11px; color: #94a3b8; }

    /* Proof btn */
    .proof-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px;
        background: #eff6ff;
        color: #2563eb;
        border: 1.5px solid #bfdbfe;
        border-radius: 12px;
        font-size: 12px; font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
    }
    .proof-btn:hover { background: #2563eb; color: white; border-color: #2563eb; }

    /* Action btns */
    .btn-approve {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 22px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none; border-radius: 12px;
        font-size: 13px; font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16,185,129,0.3);
        transition: all 0.2s;
    }
    .btn-approve:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(16,185,129,0.4); }

    .btn-reject {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 22px;
        background: white;
        color: #ef4444;
        border: 1.5px solid #fecaca;
        border-radius: 12px;
        font-size: 13px; font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-reject:hover { background: #ef4444; color: white; border-color: #ef4444; transform: translateY(-2px); }

    /* Divider */
    .card-divider {
        height: 1px; background: #f8fafc;
        margin: 0;
    }

    /* Section labels */
    .section-label {
        font-size: 10px; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.08em;
        margin-bottom: 4px;
    }

    .col-user    { flex: 2; min-width: 160px; }
    .col-amount  { flex: 1.2; min-width: 130px; }
    .col-method  { flex: 1; min-width: 120px; }
    .col-date    { flex: 1; min-width: 110px; }
    .col-proof   { flex: 1; min-width: 110px; }
    .col-action  { flex: 1.5; min-width: 180px; display: flex; gap: 8px; justify-content: flex-end; }

    .empty-state {
        background: white;
        border-radius: 24px;
        border: 1px solid #f1f5f9;
        padding: 80px 32px;
        text-align: center;
        box-shadow: 0 4px 24px rgba(0,0,0,0.04);
    }
    .empty-icon {
        width: 80px; height: 80px;
        background: #f8fafc;
        border-radius: 24px;
        border: 2px dashed #e2e8f0;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }
</style>
@endsection

@section('content')
<div class="topup-page">

    {{-- Premium Header --}}
    <div class="page-header">
        <div style="position:relative; z-index:1;">
            <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; opacity:0.75; margin-bottom:8px;">Admin · Keuangan</p>
            <h1 style="font-size:28px; font-weight:900; margin-bottom:8px; font-family:'Outfit',sans-serif;">Permintaan Top‑Up</h1>
            <p style="font-size:14px; opacity:0.8; margin-bottom:20px;">Tinjau bukti pembayaran dan setujui permintaan pengisian saldo pengguna.</p>
            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <div class="badge">
                    <i data-lucide="clock" style="width:14px;height:14px;"></i>
                    {{ $pendingTopups->count() }} Menunggu Persetujuan
                </div>
                @if($pendingTopups->count() > 0)
                <div class="badge">
                    <i data-lucide="banknote" style="width:14px;height:14px;"></i>
                    Total: Rp{{ number_format($pendingTopups->sum('amount'), 0, ',', '.') }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Content --}}
    @if($pendingTopups->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i data-lucide="inbox" style="width:36px;height:36px;color:#cbd5e1;"></i>
            </div>
            <h3 style="font-size:18px; font-weight:800; color:#1e293b; margin-bottom:8px; font-family:'Outfit',sans-serif;">Semua beres! 🎉</h3>
            <p style="font-size:14px; color:#94a3b8;">Tidak ada permintaan top‑up yang menunggu persetujuan.</p>
        </div>
    @else
        {{-- Top-Up Request Cards --}}
        @foreach($pendingTopups as $topup)
        @php
            $method = strtolower($topup->payment_method);
            $isEwallet = in_array($method, ['gopay','ovo','dana','linkaja','shopeepay']);
            $methodStyle = match(true) {
                $isEwallet               => ['color:#059669; background:#ecfdf5; border-color:#a7f3d0;', 'smartphone'],
                $method === 'qris'       => ['color:#7c3aed; background:#f5f3ff; border-color:#ddd6fe;', 'qr-code'],
                str_contains($method,'kartu') => ['color:#2563eb; background:#eff6ff; border-color:#bfdbfe;', 'credit-card'],
                in_array($method,['indomaret','alfamart']) => ['color:#d97706; background:#fffbeb; border-color:#fde68a;', 'store'],
                default                  => ['color:#475569; background:#f8fafc; border-color:#e2e8f0;', 'building-2'],
            };
            $colors = ['#6366f1','#8b5cf6','#3b82f6','#10b981','#f59e0b','#ef4444'];
            $colorIdx = crc32($topup->user->name) % count($colors);
            $avatarColor = $colors[abs($colorIdx)];
        @endphp

        <div class="topup-card">
            <div class="card-body">
                {{-- User --}}
                <div class="col-user" style="display:flex; align-items:center; gap:14px;">
                    <div class="user-avatar" style="background: linear-gradient(135deg, {{ $avatarColor }}, #a78bfa);">
                        {{ strtoupper(substr($topup->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="section-label">Pengguna</div>
                        <p style="font-weight:800; color:#0f172a; font-size:14px; line-height:1.3;">{{ $topup->user->name }}</p>
                        <p style="font-size:11px; color:#94a3b8;">{{ $topup->user->email }}</p>
                    </div>
                </div>

                {{-- Amount --}}
                <div class="col-amount">
                    <div class="section-label">Jumlah</div>
                    <div class="amount-badge">Rp{{ number_format($topup->amount, 0, ',', '.') }}</div>
                </div>

                {{-- Method --}}
                <div class="col-method">
                    <div class="section-label">Metode</div>
                    <span class="method-pill" style="{{ $methodStyle[0] }}">
                        <i data-lucide="{{ $methodStyle[1] }}" style="width:12px;height:12px;"></i>
                        {{ ucwords($topup->payment_method) }}
                    </span>
                </div>

                {{-- Date --}}
                <div class="col-date">
                    <div class="section-label">Tanggal</div>
                    <p class="date-text">{{ $topup->created_at->format('d M Y') }}</p>
                    <p class="date-sub">{{ $topup->created_at->format('H:i') }} WIB</p>
                </div>

                {{-- Proof --}}
                <div class="col-proof">
                    <div class="section-label">Bukti Bayar</div>
                    @if($topup->proof_image)
                        <a href="{{ asset('storage/' . $topup->proof_image) }}" target="_blank" class="proof-btn">
                            <i data-lucide="image" style="width:13px;height:13px;"></i>
                            Lihat Bukti
                        </a>
                    @else
                        <span style="font-size:12px; color:#94a3b8;">Tidak ada</span>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="col-action">
                    <form action="{{ route('admin.topups.approve', $topup->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-approve">
                            <i data-lucide="check" style="width:14px;height:14px;"></i>
                            Approve
                        </button>
                    </form>
                    <form action="{{ route('admin.topups.reject', $topup->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-reject">
                            <i data-lucide="x" style="width:14px;height:14px;"></i>
                            Reject
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endif

</div>
@endsection
