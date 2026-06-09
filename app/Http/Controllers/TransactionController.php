<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'event', 'ticketType'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.transactions.index', compact('bookings'));
    }

    public function cancel(Request $request, Booking $booking)
    {
        if ($booking->payment_status === 'cancelled') {
            return back()->with('error', 'Transaksi ini sudah dibatalkan sebelumnya.');
        }

        // Refund balance to user
        $user = $booking->user;
        $user->balance += $booking->total_price;
        $user->save();

        // Restore ticket capacity
        $ticketType = $booking->ticketType;
        $ticketType->remaining += $booking->quantity;
        $ticketType->save();

        // Update booking status
        $booking->update([
            'payment_status' => 'cancelled'
        ]);

        return back()->with('success', 'Transaksi berhasil dibatalkan dan dana telah dikembalikan ke saldo pengguna.');
    }
}
