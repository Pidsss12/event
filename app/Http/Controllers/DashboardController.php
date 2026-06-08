<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Customer Dashboard
        $bookings = Booking::with(['event', 'ticketType'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.index', compact('user', 'bookings'));
    }

    public function adminDashboard()
    {
        // Stats
        $totalEvents = Event::count();
        $totalBookings = Booking::where('payment_status', 'paid')->count();
        $totalUsers = User::where('role', 'user')->count();
        $totalSales = Booking::where('payment_status', 'paid')->sum('total_price');

        $recentBookings = Booking::with(['event', 'ticketType', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.admin', compact('totalEvents', 'totalBookings', 'totalUsers', 'totalSales', 'recentBookings'));
    }

    // Top-up wallet simulation
    public function topUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:5000000',
        ]);

        $user = Auth::user();
        $user->balance += $request->amount;
        $user->save();

        return back()->with('success', 'Wallet topped up successfully by IDR ' . number_format($request->amount, 0, ',', '.') . '!');
    }
}
