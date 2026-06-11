@extends('layouts.dashboard')

@section('title', 'Buat Event Baru - Admin')
@section('header_title', 'Buat Event Baru')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-sA+e1kLrvb8PqK3U4Z2Vqh0M5g9fZkC1a3A2U6e4U5s=" crossorigin=""/>
<style>
    .event-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .event-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #1d4ed8 100%);
        padding: 32px;
        color: white;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .event-header::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    /* Form Fields */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-label {
        font-size: 11px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }
    .form-input {
        width: 100%;
        padding: 12px 16px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        transition: all 0.2s;
    }
    .form-input:focus {
        background: white;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    /* Live Preview Section */
    .preview-card {
        background: #f8fafc;
        border: 1.5px dashed #cbd5e1;
        border-radius: 20px;
        padding: 16px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 180px;
        overflow: hidden;
        position: relative;
        transition: all 0.22s;
    }
    .preview-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 12px;
        display: none;
    }
    .preview-placeholder {
        color: #94a3b8;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    /* Ticket tiers grid */
    .ticket-tier-card {
        border-radius: 20px;
        padding: 20px;
        border: 1.5px solid;
        transition: all 0.22s;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .ticket-tier-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
    }
    .tier-silver { border-color: #cbd5e1; background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%); }
    .tier-gold { border-color: #fde68a; background: linear-gradient(180deg, #ffffff 0%, #fffdf5 100%); }
    .tier-platinum { border-color: #ddd6fe; background: linear-gradient(180deg, #ffffff 0%, #faf5ff 100%); }

    .tier-badge {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 4px 10px;
        border-radius: 8px;
        width: fit-content;
    }
    .badge-silver { background: #e2e8f0; color: #475569; }
    .badge-gold { background: #fffbeb; color: #b45309; }
    .badge-platinum { background: #f5f3ff; color: #6d28d9; }

    /* Map Button & Modal */
    .btn-map {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: #eff6ff;
        color: #2563eb;
        border: 1.5px solid #bfdbfe;
        border-radius: 12px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        width: fit-content;
    }
    .btn-map:hover {
        background: #2563eb;
        color: white;
        border-color: #2563eb;
    }

    .btn-cancel {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 14px 24px;
        background: #f1f5f9; color: #475569;
        border-radius: 14px; font-size: 13.5px; font-weight: 800;
        text-decoration: none; transition: all 0.2s;
    }
    .btn-cancel:hover { background: #e2e8f0; color: #1e293b; }

    .btn-submit {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 14px 24px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white; border-radius: 14px; font-size: 13.5px; font-weight: 800;
        border: none; cursor: pointer;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        transition: all 0.2s;
    }
    .btn-submit:hover {
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="event-card">
        
        {{-- Header --}}
        <div class="event-header">
            <div style="position:relative; z-index:1;">
                <span style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.12em; opacity:0.85;">Kelola Event · Admin</span>
                <h1 style="font-size:24px; font-weight:900; margin-top:4px; font-family:'Outfit',sans-serif;">Buat Event Baru</h1>
            </div>
            <div style="width:48px; height:48px; background:rgba(255,255,255,0.1); backdrop-filter:blur(10px); border-radius:14px; display:flex; align-items:center; justify-content:center;">
                <i data-lucide="calendar" style="width:22px; height:22px; color:white;"></i>
            </div>
        </div>

        {{-- Form Body --}}
        <div class="p-8">
            <form action="{{ route('admin.events.store') }}" method="POST" class="space-y-8">
                @csrf

                {{-- Section 1: Informasi Utama --}}
                <div class="space-y-5">
                    <h3 style="font-size:12px; font-weight:800; color:#2563eb; text-transform:uppercase; letter-spacing:0.1em; border-bottom:1px solid #f1f5f9; padding-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i data-lucide="info" style="width:16px;height:16px;"></i>
                        1. Informasi Utama Event
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Judul Event -->
                        <div class="form-group md:col-span-2">
                            <label for="title" class="form-label">Judul Event</label>
                            <input type="text" name="title" id="title" required value="{{ old('title') }}"
                                   class="form-input" placeholder="Contoh: Grand Tech Summit & Workshop 2026">
                        </div>

                        <!-- Kategori -->
                        <div class="form-group">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select name="category_id" id="category_id" required class="form-input">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal & Waktu -->
                        <div class="form-group">
                            <label for="date_time" class="form-label">Tanggal & Waktu</label>
                            <input type="datetime-local" name="date_time" id="date_time" required value="{{ old('date_time') }}" class="form-input">
                        </div>

                        <!-- Lokasi / Venue -->
                        <div class="form-group">
                            <label for="location" class="form-label">Lokasi / Venue</label>
                            <input type="text" name="location" id="location" required value="{{ old('location') }}"
                                   class="form-input" placeholder="Contoh: JIExpo Kemayoran Hall A, Jakarta">
                            
                            <!-- Leaflet Map Button -->
                            <div style="margin-top:8px;">
                                <button id="openMapBtn" type="button" class="btn-map">
                                    <i data-lucide="map-pin" style="width:14px;height:14px;"></i>
                                    Pilih dari Peta
                                </button>
                            </div>
                            <!-- Coordinates Hidden Input -->
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                        </div>

                        <!-- URL Gambar Banner -->
                        <div class="form-group">
                            <label for="banner_image" class="form-label">URL Gambar Banner</label>
                            <input type="url" name="banner_image" id="banner_image" value="{{ old('banner_image') }}"
                                   class="form-input" placeholder="https://images.unsplash.com/...">
                        </div>

                        <!-- Banner Live Preview -->
                        <div class="form-group md:col-span-2">
                            <label class="form-label">Preview Banner Event</label>
                            <div class="preview-card" id="banner-preview-card">
                                <div class="preview-placeholder" id="preview-placeholder">
                                    <i data-lucide="image" style="width:28px;height:28px;"></i>
                                    <span style="font-size:12px; font-weight:700;">Belum ada URL Gambar</span>
                                </div>
                                <img src="" alt="Banner Preview" class="preview-image" id="preview-image">
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-group md:col-span-2">
                            <label for="description" class="form-label">Deskripsi Event</label>
                            <textarea name="description" id="description" rows="5" required
                                      class="form-input" style="resize:vertical;"
                                      placeholder="Tuliskan deskripsi lengkap agenda, pembicara, dan benefit dari event ini...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Parameter Kategori Tiket --}}
                <div class="space-y-5">
                    <h3 style="font-size:12px; font-weight:800; color:#2563eb; text-transform:uppercase; letter-spacing:0.1em; border-bottom:1px solid #f1f5f9; padding-bottom:8px; display:flex; align-items:center; gap:8px;">
                        <i data-lucide="ticket" style="width:16px;height:16px;"></i>
                        2. Kelas & Harga Tiket
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Silver Card -->
                        <div class="ticket-tier-card tier-silver">
                            <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
                                <span style="font-size:14px; font-weight:800; color:#334155;">Silver Tier</span>
                                <span class="tier-badge badge-silver">Regular</span>
                            </div>
                            <div class="space-y-4">
                                <div class="form-group">
                                    <label class="form-label" style="font-size:9px;">Harga (Rp)</label>
                                    <input type="number" name="silver_price" required value="{{ old('silver_price', 150000) }}" min="0" class="form-input" style="padding:10px 12px; font-size:13px;">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" style="font-size:9px;">Kapasitas Kursi</label>
                                    <input type="number" name="silver_capacity" required value="{{ old('silver_capacity', 100) }}" min="1" class="form-input" style="padding:10px 12px; font-size:13px;">
                                </div>
                            </div>
                        </div>

                        <!-- Gold Card -->
                        <div class="ticket-tier-card tier-gold">
                            <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
                                <span style="font-size:14px; font-weight:800; color:#334155;">Gold Tier</span>
                                <span class="tier-badge badge-gold">VIP</span>
                            </div>
                            <div class="space-y-4">
                                <div class="form-group">
                                    <label class="form-label" style="font-size:9px;">Harga (Rp)</label>
                                    <input type="number" name="gold_price" required value="{{ old('gold_price', 350000) }}" min="0" class="form-input" style="padding:10px 12px; font-size:13px;">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" style="font-size:9px;">Kapasitas Kursi</label>
                                    <input type="number" name="gold_capacity" required value="{{ old('gold_capacity', 50) }}" min="1" class="form-input" style="padding:10px 12px; font-size:13px;">
                                </div>
                            </div>
                        </div>

                        <!-- Platinum VIP -->
                        <div class="ticket-tier-card tier-platinum">
                            <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
                                <span style="font-size:14px; font-weight:800; color:#334155;">Platinum Tier</span>
                                <span class="tier-badge badge-platinum">VVIP</span>
                            </div>
                            <div class="space-y-4">
                                <div class="form-group">
                                    <label class="form-label" style="font-size:9px;">Harga (Rp)</label>
                                    <input type="number" name="platinum_price" required value="{{ old('platinum_price', 750000) }}" min="0" class="form-input" style="padding:10px 12px; font-size:13px;">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" style="font-size:9px;">Kapasitas Kursi</label>
                                    <input type="number" name="platinum_capacity" required value="{{ old('platinum_capacity', 20) }}" min="1" class="form-input" style="padding:10px 12px; font-size:13px;">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Action Buttons --}}
                <div style="display:flex; gap:16px; padding-top:24px; border-top:1px solid #f1f5f9;">
                    <a href="{{ route('admin.events.index') }}" class="btn-cancel">
                        <i data-lucide="corner-up-left" style="width:16px;height:16px;"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn-submit">
                        <i data-lucide="check-circle" style="width:16px;height:16px;"></i>
                        Buat Agenda Event
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

{{-- Leaflet Map Modal --}}
<div id="mapModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-3xl overflow-hidden w-11/12 max-w-2xl shadow-2xl border border-slate-100">
        <div style="display:flex; justify-content:space-between; align-items:center; padding:20px 24px; background:linear-gradient(135deg, #0f172a, #1e293b); color:white;">
            <h3 style="font-size:16px; font-weight:800; font-family:'Outfit',sans-serif; margin:0;">Pilih Lokasi Event</h3>
            <button id="closeMapBtn" style="background:none; border:none; color:white; font-size:24px; cursor:pointer; opacity:0.8; transition:opacity 0.2s;">&times;</button>
        </div>
        <div id="map" style="height:400px; width:100%;"></div>
        <div style="padding:16px 24px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end;">
            <button id="saveMapBtn" style="padding:10px 20px; background:#2563eb; color:white; border:none; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer;">Simpan Lokasi</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-o5w+fXxv6L1kXzY1P5z7xvU3cJ7jBrcB2XfVgDgZ3Eo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Banner image preview logic
    const bannerInput = document.getElementById('banner_image');
    const previewImage = document.getElementById('preview-image');
    const previewPlaceholder = document.getElementById('preview-placeholder');

    function updateBannerPreview() {
        const url = bannerInput.value.trim();
        if (url) {
            previewImage.src = url;
            previewImage.style.display = 'block';
            previewPlaceholder.style.display = 'none';
        } else {
            previewImage.style.display = 'none';
            previewPlaceholder.style.display = 'flex';
        }
    }

    bannerInput.addEventListener('input', updateBannerPreview);
    updateBannerPreview(); // Run once on load

    // Map Modal logic
    const openBtn = document.getElementById('openMapBtn');
    const closeBtn = document.getElementById('closeMapBtn');
    const saveBtn = document.getElementById('saveMapBtn');
    const modal = document.getElementById('mapModal');
    let map, marker;
    let initialized = false;

    // Get current coordinate or set default (Jakarta)
    let initialLat = parseFloat(document.getElementById('latitude').value) || -6.200000;
    let initialLng = parseFloat(document.getElementById('longitude').value) || 106.816666;

    openBtn.addEventListener('click', function (e) {
        e.preventDefault();
        modal.classList.remove('hidden');
        if (!initialized) {
            // Initialize map
            map = L.map('map').setView([initialLat, initialLng], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            marker = L.marker([initialLat, initialLng], {draggable:true}).addTo(map);
            updateInputs();

            marker.on('dragend', updateInputs);
            map.on('click', function(e){
                marker.setLatLng(e.latlng);
                updateInputs();
            });
            initialized = true;
        } else {
            // Relocate to inputs
            let curLat = parseFloat(document.getElementById('latitude').value) || -6.200000;
            let curLng = parseFloat(document.getElementById('longitude').value) || 106.816666;
            marker.setLatLng([curLat, curLng]);
            map.setView([curLat, curLng], 14);
        }
    });

    closeBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    saveBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    function updateInputs(){
        const pos = marker.getLatLng();
        document.getElementById('latitude').value = pos.lat.toFixed(6);
        document.getElementById('longitude').value = pos.lng.toFixed(6);
    }
});
</script>
@endsection
