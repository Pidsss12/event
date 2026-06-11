<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use App\Models\TopupRequest;
use Illuminate\Support\Facades\Storage;
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

    public function userEvents()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $events = Event::with('category')->where('date_time', '>=', now())->orderBy('date_time', 'asc')->get();
        return view('dashboard.events', compact('events'));
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

    // Show Top-Up Payment Simulation Page
    public function topUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:5000000',
        ]);

        $amount = $request->amount;
        // Generate a random virtual account number for simulation
        $virtualAccount = '8800' . rand(10000000, 99999999);

        return view('dashboard.topup-payment', compact('amount', 'virtualAccount'));
    }

    // Process the actual top-up after simulated payment
    public function processTopUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:5000000',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        // Store proof image
        $path = $request->file('proof_image')->store('topup_proofs', 'public');

        // Create a pending top-up request
        TopupRequest::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'payment_method' => $request->input('payment_method', 'bank'),
            'proof_image' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Permintaan top‑up Anda telah diajukan dan menunggu persetujuan admin.');
    }

    // Admin view pending top‑up requests
    public function adminTopups()
    {
        $pendingTopups = TopupRequest::where('status', 'pending')->with('user')->orderBy('created_at', 'desc')->get();
        return view('dashboard.admin_topups', compact('pendingTopups'));
    }
    public function approveTopup($id)
    {
        $topup = TopupRequest::findOrFail($id);
        if ($topup->status !== 'pending') {
            return redirect()->back()->with('error', 'Top‑up already processed.');
        }
        $user = $topup->user;
        $user->balance += $topup->amount;
        $user->save();
        $topup->status = 'approved';
        $topup->save();
        // Optionally delete proof image
        // Storage::delete('public/' . $topup->proof_image);
        return redirect()->back()->with('success', 'Top‑up berhasil disetujui dan saldo pengguna ditambah.');
    }

    // Admin rejects a top‑up request
    public function rejectTopup($id)
    {
        $topup = TopupRequest::findOrFail($id);
        if ($topup->status !== 'pending') {
            return redirect()->back()->with('error', 'Top‑up already processed.');
        }
        $topup->status = 'rejected';
        $topup->save();
        return redirect()->back()->with('info', 'Top‑up ditolak.');
    }
}
