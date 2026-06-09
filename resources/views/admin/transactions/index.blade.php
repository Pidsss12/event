@extends('layouts.dashboard')

@section('title', 'Manajemen Transaksi - Admin')
@section('header_title', 'Manajemen Transaksi')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Semua Transaksi Tiket</h2>
                <p class="text-sm text-slate-500">Pantau seluruh pembelian tiket dari semua event.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4 rounded-l-xl">Kode Booking & Waktu</th>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Event & Tiket</th>
                        <th class="px-6 py-4 text-right">Total Nominal</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-black text-slate-800 tracking-wider">{{ $booking->booking_code }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-700">{{ $booking->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $booking->user->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800 max-w-xs truncate" title="{{ $booking->event->title }}">{{ $booking->event->title }}</p>
                                <div class="flex gap-2 mt-1">
                                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">{{ $booking->ticketType->name }}</span>
                                    <span class="text-xs text-slate-500">x{{ $booking->quantity }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-bold text-slate-800">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($booking->payment_status == 'paid')
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-lg text-xs font-bold uppercase tracking-wider">Paid</span>
                                @else
                                    <span class="px-3 py-1 bg-rose-50 text-rose-700 border border-rose-100 rounded-lg text-xs font-bold uppercase tracking-wider">Cancelled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('bookings.receipt', $booking->booking_code) }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-bold transition-colors border border-blue-100" target="_blank" title="Lihat Bukti/Tiket">
                                        Lihat Tiket
                                    </a>
                                    @if($booking->payment_status == 'paid')
                                        <form action="{{ route('admin.transactions.cancel', $booking->id) }}" method="POST" class="delete-confirm">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition-colors border border-rose-100">
                                                Batalkan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400 italic px-2">Dibatalkan</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Belum ada transaksi tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
