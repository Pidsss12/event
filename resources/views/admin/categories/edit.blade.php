@extends('layouts.admin')

@section('title', 'Edit Kategori - Admin EventHub')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
        
        <!-- Header -->
        <div class="p-8 bg-slate-900 text-white flex justify-between items-center">
            <div>
                <span class="text-[10px] text-blue-400 font-extrabold uppercase tracking-widest block">Kelola Kategori</span>
                <h2 class="text-xl sm:text-2xl font-extrabold">Edit Kategori</h2>
            </div>
            <i data-lucide="tag" class="w-10 h-10 text-blue-400"></i>
        </div>

        <!-- Form Body -->
        <div class="p-8">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="space-y-1.5">
                    <label for="name" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Kategori</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $category->name) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                           placeholder="Contoh: Webinar Bisnis">
                </div>

                <!-- Description -->
                <div class="space-y-1.5">
                    <label for="description" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                              placeholder="Deskripsi singkat kategori ini">{{ old('description', $category->description) }}</textarea>
                </div>

                <!-- Icon Name -->
                <div class="space-y-1.5">
                    <label for="icon" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Class Icon (Lucide)</label>
                    <div class="relative">
                        <i data-lucide="tag" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                        <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}"
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                               placeholder="Contoh: music, presentation, tag">
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="flex gap-4 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.categories.index') }}" class="w-1/3 text-center py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-bold transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20 hover:-translate-y-0.5 transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
