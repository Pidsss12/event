@extends('layouts.dashboard')

@section('title', 'Kategori Event - Admin')
@section('header_title', 'Kategori Event')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Side: Add Category Form (Span 4) -->
        <div class="lg:col-span-4 bg-white border border-slate-100 shadow-xl rounded-3xl p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-lg font-extrabold text-slate-800 flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-blue-600"></i> Kategori Baru
                </h2>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Name -->
                <div class="space-y-1.5">
                    <label for="name" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Kategori</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                           placeholder="Contoh: Webinar Bisnis">
                </div>

                <!-- Description -->
                <div class="space-y-1.5">
                    <label for="description" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                              placeholder="Deskripsi singkat kategori ini">{{ old('description') }}</textarea>
                </div>

                <!-- Icon Name -->
                <div class="space-y-1.5">
                    <label for="icon" class="text-xs font-bold text-slate-700 uppercase tracking-wider">Class Icon (Lucide)</label>
                    <div class="relative">
                        <i data-lucide="tag" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                        <input type="text" name="icon" id="icon" value="{{ old('icon', 'tag') }}"
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                               placeholder="Contoh: music, presentation, tag">
                    </div>
                    <span class="text-[10px] text-slate-400 font-bold block mt-1">Nama icon sesuai pustaka Lucide (e.g. mic, users, wallet, activity).</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20 transition">
                    Simpan Kategori
                </button>
            </form>
        </div>

        <!-- Right Side: Categories Table (Span 8) -->
        <div class="lg:col-span-8 bg-white border border-slate-100 shadow-xl rounded-3xl p-6 sm:p-8 space-y-6">
            <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                <h2 class="text-xl font-extrabold text-slate-800 flex items-center gap-2">
                    <i data-lucide="tag" class="w-5 h-5 text-blue-600"></i> Daftar Kategori Event
                </h2>
            </div>

            @if($categories->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-slate-600 text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 text-xs font-bold uppercase tracking-wider">
                                <th class="pb-3 pr-4">Icon</th>
                                <th class="pb-3 px-4">Nama Kategori</th>
                                <th class="pb-3 px-4">Slug</th>
                                <th class="pb-3 px-4 text-center">Jumlah Event</th>
                                <th class="pb-3 pl-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50 transition">
                                    <td class="py-4 pr-4">
                                        <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl w-fit">
                                            <i data-lucide="{{ $category->icon ?: 'tag' }}" class="w-4 h-4"></i>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 font-bold text-slate-900">{{ $category->name }}</td>
                                    <td class="py-4 px-4 font-semibold text-slate-400">{{ $category->slug }}</td>
                                    <td class="py-4 px-4 text-center font-bold text-slate-700">{{ $category->events_count }}</td>
                                    <td class="py-4 pl-4 text-right">
                                        <div class="flex gap-2 justify-end">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline delete-confirm">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 bg-slate-50 rounded-2xl">
                    <p class="text-sm font-semibold text-slate-500">Belum ada kategori yang dibuat.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
