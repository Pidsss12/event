@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna - Admin')
@section('header_title', 'Manajemen Pengguna')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #7c3aed 0%, #6366f1 60%, #818cf8 100%);
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
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
    }
    .page-header::after {
        content: '';
        position: absolute;
        bottom: -50px; left: 20%;
        width: 150px; height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .page-header .badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 50px;
        padding: 5px 14px;
        font-size: 12px; font-weight: 700;
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
        background: #f5f3ff;
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
        width: 44px; height: 44px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 800; font-size: 16px;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(99,102,241,0.2);
    }

    .role-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 11px; font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border: 1.5px solid;
    }
    .role-admin { color: #7c3aed; background: #f5f3ff; border-color: #ddd6fe; }
    .role-user  { color: #475569; background: #f8fafc; border-color: #e2e8f0; }

    .balance-text {
        font-size: 14px; font-weight: 800; color: #059669;
    }

    .btn-sm {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 7px 16px;
        border-radius: 10px;
        font-size: 12px; font-weight: 700;
        cursor: pointer;
        border: 1.5px solid;
        transition: all 0.18s;
        background: none;
    }
    .btn-promote { color: #2563eb; border-color: #bfdbfe; background: #eff6ff; }
    .btn-promote:hover { background: #2563eb; color: white; border-color: #2563eb; transform: translateY(-1px); }
    .btn-demote  { color: #d97706; border-color: #fde68a; background: #fffbeb; }
    .btn-demote:hover { background: #d97706; color: white; border-color: #d97706; transform: translateY(-1px); }
</style>
@endsection

@section('content')
<div>

    {{-- Header --}}
    <div class="page-header">
        <div style="position:relative; z-index:1;">
            <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; opacity:0.7; margin-bottom:6px;">Admin · Sistem</p>
            <h1 style="font-size:26px; font-weight:900; margin-bottom:6px; font-family:'Outfit',sans-serif;">Manajemen Pengguna</h1>
            <p style="font-size:13px; opacity:0.75; margin-bottom:18px;">Kelola role dan pantau semua pengguna platform.</p>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <div class="badge">
                    <i data-lucide="users" style="width:13px;height:13px;"></i>
                    {{ $users->total() }} Pengguna Terdaftar
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="main-card">
        <div class="card-head">
            <div class="card-head-icon">
                <i data-lucide="user-check" style="width:20px;height:20px;color:#7c3aed;"></i>
            </div>
            <div>
                <h2 style="font-size:15px; font-weight:800; color:#0f172a;">Daftar Pengguna</h2>
                <p style="font-size:12px; color:#94a3b8;">Ubah role pengguna sesuai kebutuhan</p>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th style="text-align:left;">Pengguna</th>
                        <th style="text-align:left;">Bergabung</th>
                        <th style="text-align:right;">Saldo Wallet</th>
                        <th style="text-align:center;">Role</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    @php
                        $colors = ['#6366f1','#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4'];
                        $ci = abs(crc32($u->name)) % count($colors);
                        $ac = $colors[$ci];
                    @endphp
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="user-avatar" style="background: linear-gradient(135deg, {{ $ac }}, #a78bfa);">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p style="font-size:14px; font-weight:700; color:#0f172a;">{{ $u->name }}</p>
                                    <p style="font-size:11px; color:#94a3b8;">{{ $u->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p style="font-size:13px; font-weight:600; color:#475569;">{{ $u->created_at->format('d M Y') }}</p>
                            <p style="font-size:11px; color:#94a3b8;">{{ $u->created_at->diffForHumans() }}</p>
                        </td>
                        <td style="text-align:right;">
                            <span class="balance-text">Rp{{ number_format($u->balance, 0, ',', '.') }}</span>
                        </td>
                        <td style="text-align:center;">
                            @if($u->role == 'admin')
                                <span class="role-pill role-admin">
                                    <i data-lucide="shield-check" style="width:11px;height:11px;"></i> Admin
                                </span>
                            @else
                                <span class="role-pill role-user">
                                    <i data-lucide="user" style="width:11px;height:11px;"></i> User
                                </span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if(auth()->id() !== $u->id)
                                <form action="{{ route('admin.users.role', $u->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="role" value="{{ $u->role == 'admin' ? 'user' : 'admin' }}">
                                    <button type="submit" class="btn-sm {{ $u->role == 'admin' ? 'btn-demote' : 'btn-promote' }}">
                                        <i data-lucide="{{ $u->role == 'admin' ? 'user' : 'shield' }}" style="width:12px;height:12px;"></i>
                                        Jadikan {{ $u->role == 'admin' ? 'User' : 'Admin' }}
                                    </button>
                                </form>
                            @else
                                <span style="font-size:12px; color:#94a3b8; font-style:italic; padding:6px 12px; background:#f8fafc; border-radius:8px;">Akun Anda</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:64px 20px; text-align:center;">
                            <div style="display:flex;flex-direction:column;align-items:center;gap:12px;">
                                <div style="width:64px;height:64px;background:#f8fafc;border-radius:20px;border:2px dashed #e2e8f0;display:flex;align-items:center;justify-content:center;">
                                    <i data-lucide="users" style="width:28px;height:28px;color:#cbd5e1;"></i>
                                </div>
                                <p style="font-size:14px;font-weight:700;color:#64748b;">Tidak ada pengguna</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div style="padding: 20px 28px; border-top: 1px solid #f8fafc;">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
