<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = EventCategory::withCount('events')->get();
        
        $query = Event::with(['category', 'ticketTypes'])->where('status', 'approved');

        // Filter by search query
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category slug
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $events = $query->orderBy('date_time', 'asc')->get();

        // Find the soonest event for the Hero countdown section
        $featuredEvent = Event::with('ticketTypes')
            ->where('status', 'approved')
            ->where('date_time', '>', now())
            ->orderBy('date_time', 'asc')
            ->first();

        // Fallback to any event if none is in the future
        if (!$featuredEvent) {
            $featuredEvent = Event::with('ticketTypes')->where('status', 'approved')->first();
        }

        return view('home', compact('categories', 'events', 'featuredEvent'));
    }
}
