<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // User: Show Checkout Form
    public function checkoutForm(Request $request)
    {
        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $ticketType = TicketType::with('event')->findOrFail($request->ticket_type_id);
        $quantity = $request->quantity;
        $totalPrice = $ticketType->price * $quantity;

        return view('bookings.checkout', compact('ticketType', 'quantity', 'totalPrice'));
    }

    // User: Process Checkout
    public function storeBooking(Request $request)
    {
        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1|max:10',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $ticketType = TicketType::findOrFail($request->ticket_type_id);
        $quantity = $request->quantity;
        $totalPrice = $ticketType->price * $quantity;

        // Perform transactional operations
        try {
            $booking = DB::transaction(function () use ($user, $ticketType, $quantity, $totalPrice, $request) {
                // Re-fetch ticket to lock for update and verify remaining
                $ticket = TicketType::lockForUpdate()->findOrFail($ticketType->id);

                if ($ticket->remaining < $quantity) {
                    throw new \Exception('Sorry, not enough tickets remaining for this tier.');
                }

                // Check wallet balance
                if ($user->balance < $totalPrice) {
                    throw new \Exception('Insufficient wallet balance. Please top up in your dashboard.');
                }

                // Deduct balance from user
                $user->balance -= $totalPrice;
                $user->save();

                // Deduct remaining tickets
                $ticket->remaining -= $quantity;
                $ticket->save();

                // Generate unique booking code
                $bookingCode = 'EVT-' . strtoupper(Str::random(8));
                while (Booking::where('booking_code', $bookingCode)->exists()) {
                    $bookingCode = 'EVT-' . strtoupper(Str::random(8));
                }

                // Create booking record
                return Booking::create([
                    'user_id' => $user->id,
                    'event_id' => $ticket->event_id,
                    'ticket_type_id' => $ticket->id,
                    'booking_code' => $bookingCode,
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                    'payment_status' => 'paid',
                    'payment_method' => $request->payment_method,
                    'booked_at' => now(),
                ]);
            });

            return redirect()->route('bookings.receipt', $booking->booking_code)
                ->with('success', 'Booking completed successfully! Your digital ticket is ready.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    // User/Admin: Show Receipt
    public function showReceipt($code)
    {
        $booking = Booking::with(['event', 'ticketType', 'user'])
            ->where('booking_code', $code)
            ->firstOrFail();

        // Security check: Only the booking owner or an admin can view this receipt
        if (Auth::id() !== $booking->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('bookings.receipt', compact('booking'));
    }

    // User/Admin: Cancel Booking
    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);

        // Security check: Only the booking owner or an admin can cancel
        if (Auth::id() !== $booking->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->payment_status === 'cancelled') {
            return back()->with('error', 'Booking is already cancelled.');
        }

        try {
            DB::transaction(function () use ($booking) {
                // Refund user balance
                $user = $booking->user;
                $user->balance += $booking->total_price;
                $user->save();

                // Restore ticket remaining count
                $ticket = $booking->ticketType;
                $ticket->remaining += $booking->quantity;
                $ticket->save();

                // Mark booking cancelled
                $booking->payment_status = 'cancelled';
                $booking->save();
            });

            return back()->with('success', 'Booking cancelled successfully. Funds have been refunded to the wallet.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cancel booking: ' . $e->getMessage());
        }
    }
}
