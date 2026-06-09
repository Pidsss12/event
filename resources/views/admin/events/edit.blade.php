@extends('layouts.dashboard')

@section('title', 'Edit Event - Admin')
@section('header_title', 'Edit Event')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
        
        <!-- Header -->
        <div class="p-8 bg-slate-900 text-white flex justify-between items-center">
            <div>
                <span class="text-[10px] text-blue-400 font-extrabold uppercase tracking-widest block">Kelola Event</span>
                <h2 class="text-xl sm:text-2xl font-extrabold">Edit Event</h2>
            </div>
            <i data-lucide="edit" class="w-10 h-10 text-blue-400"></i>
        </div>

        <!-- Form Body -->
        <div class="p-8">
            <form action="{{ route('admin.events.update', $event->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Section: Informasi Utama -->
                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2">1. Informasi Utama</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Judul -->
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="title" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Judul Event</label>
                            <input type="text" name="title" id="title" required value="{{ old('title', $event->title) }}"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                                   placeholder="Contoh: Grand Tech Conference 2026">
                        </div>

                        <!-- Kategori -->
                        <div class="space-y-1.5">
                            <label for="category_id" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Kategori</label>
                            <select name="category_id" id="category_id" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $event->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal & Waktu -->
                        <div class="space-y-1.5">
                            <label for="date_time" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal & Waktu</label>
                            <input type="datetime-local" name="date_time" id="date_time" required 
                                   value="{{ old('date_time', $event->date_time ? $event->date_time->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                        </div>

                        <!-- Lokasi -->
                        <div class="space-y-1.5">
                            <label for="location" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Lokasi / Venue</label>
                            <input type="text" name="location" id="location" required value="{{ old('location', $event->location) }}"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                                   placeholder="Contoh: Gedung Hall A, Jakarta atau Online (Zoom)">
                        </div>

                        <!-- Banner Image URL -->
                        <div class="space-y-1.5">
                            <label for="banner_image" class="text-xs font-bold text-slate-700 uppercase tracking-wider">URL Gambar Banner</label>
                            <input type="url" name="banner_image" id="banner_image" value="{{ old('banner_image', $event->banner_image) }}"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                                   placeholder="https://images.unsplash.com/...">
                        </div>

                        <!-- Deskripsi -->
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="description" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi Event</label>
                            <textarea name="description" id="description" rows="5" required
                                      class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                                      placeholder="Tuliskan deskripsi lengkap...">{{ old('description', $event->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Section: Parameter Kategori Tiket -->
                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2">2. Pengaturan Tiket (3 Kelas)</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Silver ticket parameters -->
                        @php
                            $silver = $tickets->get('Silver Ticket');
                            $gold = $tickets->get('Gold Ticket');
                            $platinum = $tickets->get('Platinum VIP');
                        @endphp
                        
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-900 block">Silver Ticket</span>
                                <span class="px-2 py-0.5 bg-slate-200 text-slate-600 text-[9px] font-bold rounded">Regular</span>
                            </div>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Harga (Rp)</label>
                                    <input type="number" name="silver_price" required value="{{ old('silver_price', $silver ? $silver->price : 150000) }}" min="0"
                                           class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-blue-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Kapasitas Kursi</label>
                                    <input type="number" name="silver_capacity" required value="{{ old('silver_capacity', $silver ? $silver->capacity : 100) }}" min="1"
                                           class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-blue-500 focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- Gold ticket parameters -->
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-900 block">Gold Ticket</span>
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[9px] font-bold rounded">VIP</span>
                            </div>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Harga (Rp)</label>
                                    <input type="number" name="gold_price" required value="{{ old('gold_price', $gold ? $gold->price : 350000) }}" min="0"
                                           class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-blue-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Kapasitas Kursi</label>
                                    <input type="number" name="gold_capacity" required value="{{ old('gold_capacity', $gold ? $gold->capacity : 50) }}" min="1"
                                           class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-blue-500 focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- Platinum VIP parameters -->
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-900 block">Platinum VIP</span>
                                <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-[9px] font-bold rounded">VVIP</span>
                            </div>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Harga (Rp)</label>
                                    <input type="number" name="platinum_price" required value="{{ old('platinum_price', $platinum ? $platinum->price : 750000) }}" min="0"
                                           class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-blue-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Kapasitas Kursi</label>
                                    <input type="number" name="platinum_capacity" required value="{{ old('platinum_capacity', $platinum ? $platinum->capacity : 20) }}" min="1"
                                           class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-blue-500 focus:outline-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit buttons -->
                <div class="flex gap-4 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.events.index') }}" class="w-1/4 text-center py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-bold transition">
                        Batal
                    </a>
                    <button type="submit" class="w-3/4 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20 hover:-translate-y-0.5 transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
