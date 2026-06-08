@extends('layouts.admin')

@section('title', 'Kelola Event - Admin EventHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-6 sm:p-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-xl font-extrabold text-slate-800 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i> Kelola Agenda Event
                </h2>
                <p class="text-xs text-slate-500 mt-1">Buat, perbarui, dan hapus event serta tiket digital.</p>
            </div>
            <a href="{{ route('admin.events.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs flex items-center gap-2 shadow-lg shadow-blue-500/20 transition">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Buat Event Baru
            </a>
        </div>

        <!-- Events list -->
        @if($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-slate-600 text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="pb-3 pr-4">Banner</th>
                            <th class="pb-3 px-4">Judul Event</th>
                            <th class="pb-3 px-4">Kategori</th>
                            <th class="pb-3 px-4">Waktu</th>
                            <th class="pb-3 px-4">Lokasi</th>
                            <th class="pb-3 pl-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                            <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50 transition">
                                <td class="py-4 pr-4">
                                    <img src="{{ $event->banner_image }}" alt="{{ $event->title }}" class="w-16 h-10 object-cover rounded-lg shadow-sm">
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-900">
                                    <a href="{{ route('events.show', $event->slug) }}" class="hover:text-blue-600 transition">
                                        {{ $event->title }}
                                    </a>
                                </td>
                                <td class="py-4 px-4 font-semibold text-slate-700">
                                    {{ $event->category->name }}
                                </td>
                                <td class="py-4 px-4 text-xs font-bold text-slate-400">
                                    {{ $event->date_time->translatedFormat('d M Y') }}<br>
                                    {{ $event->date_time->format('H:i') }} WIB
                                </td>
                                <td class="py-4 px-4 text-xs text-slate-500 max-w-xs truncate">
                                    {{ $event->location }}
                                </td>
                                <td class="py-4 pl-4 text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Semua data tiket & pemesanan terkait akan ikut terhapus.')" class="inline">
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
            <!-- Empty state -->
            <div class="text-center py-16 bg-slate-50 rounded-2xl">
                <i data-lucide="calendar" class="w-8 h-8 text-slate-400 mx-auto mb-3"></i>
                <p class="text-sm font-semibold text-slate-500">Belum ada agenda event yang terdaftar.</p>
            </div>
        @endif

    </div>
</div>
@endsection
