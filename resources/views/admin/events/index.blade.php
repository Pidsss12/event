@extends('layouts.dashboard')

@section('title', 'Kelola Event - Admin')
@section('header_title', 'Kelola Event')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #1d4ed8 100%);
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
    .page-header .badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 50px;
        padding: 5px 14px;
        font-size: 12px; font-weight: 700;
    }
    .btn-create {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 22px;
        background: white;
        color: #1d4ed8;
        border-radius: 14px;
        font-size: 13px; font-weight: 800;
        text-decoration: none;
        box-shadow: 0 4px 16px rgba(255,255,255,0.2);
        transition: all 0.2s;
        border: none;
    }
    .btn-create:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255,255,255,0.25); }

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

    .event-row {
        display: flex;
        align-items: center;
        padding: 16px 28px;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.15s;
        gap: 16px;
    }
    .event-row:last-child { border-bottom: none; }
    .event-row:hover { background: #fafbff; }

    .event-banner {
        width: 80px; height: 54px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .event-info { flex: 1; min-width: 0; }
    .event-title {
        font-size: 14px; font-weight: 800; color: #0f172a;
        text-decoration: none;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        display: block;
    }
    .event-title:hover { color: #2563eb; }

    .cat-pill {
        display: inline-flex; align-items: center;
        padding: 3px 10px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 6px;
        font-size: 11px; font-weight: 700;
        margin-top: 4px;
    }

    .date-col { flex-shrink: 0; width: 120px; }
    .location-col { flex-shrink: 0; width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .action-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px;
        border-radius: 10px;
        border: 1.5px solid;
        cursor: pointer;
        transition: all 0.18s;
        background: none;
        text-decoration: none;
    }
    .action-edit { color: #2563eb; border-color: #bfdbfe; background: #eff6ff; }
    .action-edit:hover { background: #2563eb; color: white; border-color: #2563eb; transform: translateY(-1px); }
    .action-delete { color: #dc2626; border-color: #fecaca; background: #fef2f2; }
    .action-delete:hover { background: #dc2626; color: white; border-color: #dc2626; transform: translateY(-1px); }

    .empty-state {
        padding: 80px 20px;
        text-align: center;
        display: flex; flex-direction: column; align-items: center; gap: 16px;
    }
    .empty-icon {
        width: 72px; height: 72px;
        background: #f8fafc;
        border-radius: 22px;
        border: 2px dashed #e2e8f0;
        display: flex; align-items: center; justify-content: center;
    }
</style>
@endsection

@section('content')
<div>

    {{-- Header --}}
    <div class="page-header">
        <div style="position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
            <div>
                <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; opacity:0.7; margin-bottom:6px;">Admin · Event</p>
                <h1 style="font-size:26px; font-weight:900; margin-bottom:6px; font-family:'Outfit',sans-serif;">Kelola Agenda Event</h1>
                <p style="font-size:13px; opacity:0.75; margin-bottom:16px;">Buat, perbarui, dan hapus event serta tiket digital.</p>
                <div class="badge">
                    <i data-lucide="calendar" style="width:13px;height:13px;"></i>
                    {{ $events->count() }} Event Terdaftar
                </div>
            </div>
            <a href="{{ route('admin.events.create') }}" class="btn-create">
                <i data-lucide="plus-circle" style="width:16px;height:16px;"></i>
                Buat Event Baru
            </a>
        </div>
    </div>

    {{-- Events Card --}}
    <div class="main-card">
        <div class="card-head">
            <div class="card-head-icon">
                <i data-lucide="calendar-days" style="width:20px;height:20px;color:#2563eb;"></i>
            </div>
            <div>
                <h2 style="font-size:15px; font-weight:800; color:#0f172a;">Daftar Event</h2>
                <p style="font-size:12px; color:#94a3b8;">Klik edit untuk mengubah detail event</p>
            </div>
        </div>

        @if($events->count() > 0)
            {{-- Table header --}}
            <div style="display:flex; align-items:center; padding:10px 28px; border-bottom:1px solid #f1f5f9; background:#f8fafc; gap:16px;">
                <div style="width:80px; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.07em;">No</div>
                <div style="width:80px; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.07em;">Banner</div>
                <div style="flex:1; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.07em;">Event</div>
                <div style="width:120px; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.07em;">Tanggal</div>
                <div style="width:150px; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.07em;">Lokasi</div>
                <div style="width:80px; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.07em; text-align:right;">Aksi</div>
            </div>

            @foreach($events as $event)
            <div class="event-row">
                <div style="width:80px; font-size:13px; font-weight:700; color:#475569; padding-left:4px;">{{ $loop->iteration }}</div>
                <img src="{{ $event->banner_image }}" alt="{{ $event->title }}" class="event-banner">
                <div class="event-info">
                    <a href="{{ route('events.show', $event->slug) }}" class="event-title">{{ $event->title }}</a>
                    <span class="cat-pill">{{ $event->category->name }}</span>
                </div>
                <div class="date-col">
                    <p style="font-size:12px; font-weight:700; color:#334155;">{{ $event->date_time->translatedFormat('d M Y') }}</p>
                    <p style="font-size:11px; color:#94a3b8;">{{ $event->date_time->format('H:i') }} WIB</p>
                </div>
                <div class="location-col">
                    <p style="font-size:12px; color:#64748b; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $event->location }}</p>
                </div>
                <div style="display:flex; gap:8px; flex-shrink:0;">
                    <a href="{{ route('admin.events.edit', $event->id) }}" class="action-btn action-edit" title="Edit">
                        <i data-lucide="edit-3" style="width:15px;height:15px;"></i>
                    </a>
                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="delete-confirm" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn action-delete" title="Hapus">
                            <i data-lucide="trash-2" style="width:15px;height:15px;"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i data-lucide="calendar-x" style="width:32px;height:32px;color:#cbd5e1;"></i>
                </div>
                <h3 style="font-size:16px; font-weight:800; color:#334155;">Belum ada event</h3>
                <p style="font-size:13px; color:#94a3b8; max-width:280px;">Mulai buat event pertama Anda untuk ditampilkan kepada pengguna.</p>
                <a href="{{ route('admin.events.create') }}" class="btn-create" style="background:#2563eb; color:white; box-shadow: 0 4px 12px rgba(37,99,235,0.3);">
                    <i data-lucide="plus-circle" style="width:15px;height:15px;"></i>
                    Buat Event Pertama
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
