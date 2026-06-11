<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'proof_of_payment' => 'nullable|required_unless:payment_method,Wallet EventHub|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $ticketType = TicketType::findOrFail($request->ticket_type_id);
        $quantity = $request->quantity;
        $totalPrice = $ticketType->price * $quantity;
        $isEventHubPay = $request->payment_method === 'Wallet EventHub';

        // Handle File Upload
        $proofPath = null;
        if (!$isEventHubPay && $request->hasFile('proof_of_payment')) {
            $proofPath = $request->file('proof_of_payment')->store('proofs', 'public');
        }

        // Perform transactional operations
        try {
            $booking = DB::transaction(function () use ($user, $ticketType, $quantity, $totalPrice, $request, $isEventHubPay, $proofPath) {
                // Re-fetch ticket to lock for update and verify remaining
                $ticket = TicketType::lockForUpdate()->findOrFail($ticketType->id);

                if ($ticket->remaining < $quantity) {
                    throw new \Exception('Maaf, tiket untuk kategori ini tidak cukup.');
                }

                if ($isEventHubPay) {
                    // Check wallet balance
                    if ($user->balance < $totalPrice) {
                        throw new \Exception('Saldo dompet tidak mencukupi. Silakan top-up terlebih dahulu.');
                    }
                    // Deduct balance from user
                    $user->balance -= $totalPrice;
                    $user->save();
                }

                // Deduct remaining tickets (reserved)
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
                    'payment_status' => $isEventHubPay ? 'paid' : 'pending',
                    'payment_method' => $request->payment_method,
                    'proof_of_payment' => $proofPath,
                    'booked_at' => now(),
                ]);
            });

            $message = $isEventHubPay 
                ? 'Booking berhasil! Tiket digital Anda sudah siap.' 
                : 'Pemesanan berhasil. Menunggu konfirmasi admin untuk bukti pembayaran Anda.';

            return redirect()->route('bookings.receipt', $booking->booking_code)
                ->with('success', $message);

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

    // User/Admin: Download PDF Receipt
    public function downloadPdf($code)
    {
        $booking = Booking::with(['event', 'ticketType', 'user'])
            ->where('booking_code', $code)
            ->firstOrFail();

        // Security check
        if (Auth::id() !== $booking->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure only paid bookings can be downloaded as PDF
        if ($booking->payment_status !== 'paid') {
            abort(403, 'Ticket not available for download until payment is confirmed.');
        }
        try {
            $imageData = base64_encode(file_get_contents($booking->event->banner_image));
            $bannerSrc = 'data:image/jpeg;base64,'.$imageData;
        } catch (\Exception $e) {
            $bannerSrc = null;
        }

        $pdf = Pdf::loadView('bookings.pdf', compact('booking', 'bannerSrc'));
        return $pdf->download('Tiket-EventHub-' . $booking->booking_code . '.pdf');
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
