<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Public: Show single event details
    public function show($slug)
    {
        $event = Event::with(['category', 'ticketTypes', 'organizer'])->where('slug', $slug)->firstOrFail();
        return view('events.show', compact('event'));
    }

    // Admin: List all events
    public function adminIndex()
    {
        $events = Event::with(['category', 'organizer'])->orderBy('created_at', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    // Admin: Show create event form
    public function create()
    {
        $categories = EventCategory::all();
        return view('admin.events.create', compact('categories'));
    }

    // Admin: Store new event
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:event_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'strategic_location' => 'nullable|string|max:255',
            'date_time' => 'required|date',
            'longitude' => 'nullable|numeric',
            // Ticket parameters
            'silver_price' => 'required|numeric|min:0',
            'silver_capacity' => 'required|integer|min:1',
            'gold_price' => 'required|numeric|min:0',
            'gold_capacity' => 'required|integer|min:1',
            'platinum_price' => 'required|numeric|min:0',
            'platinum_capacity' => 'required|integer|min:1',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Set fallback banner image if empty
        $banner = $request->banner_image ?: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1200&auto=format&fit=crop';

        $event = Event::create([
            'category_id' => $request->category_id,
            'organizer_id' => Auth::id(),
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'location' => $request->location,
            'strategic_location' => $request->strategic_location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'date_time' => $request->date_time,
            'banner_image' => $banner,
            'status' => 'approved',
        ]);

        // Create the three ticket types
        TicketType::create([
            'event_id' => $event->id,
            'name' => 'Silver Ticket',
            'price' => $request->silver_price,
            'capacity' => $request->silver_capacity,
            'remaining' => $request->silver_capacity,
        ]);

        TicketType::create([
            'event_id' => $event->id,
            'name' => 'Gold Ticket',
            'price' => $request->gold_price,
            'capacity' => $request->gold_capacity,
            'remaining' => $request->gold_capacity,
        ]);

        TicketType::create([
            'event_id' => $event->id,
            'name' => 'Platinum VIP',
            'price' => $request->platinum_price,
            'capacity' => $request->platinum_capacity,
            'remaining' => $request->platinum_capacity,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully along with ticket types!');
    }

    // Admin: Show edit event form
    public function edit(Event $event)
    {
        $categories = EventCategory::all();
        $tickets = $event->ticketTypes->keyBy('name');
        return view('admin.events.edit', compact('event', 'categories', 'tickets'));
    }

    // Admin: Update event
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'category_id' => 'required|exists:event_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date_time' => 'required|date',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            // Ticket parameters
            'silver_price' => 'required|numeric|min:0',
            'silver_capacity' => 'required|integer|min:1',
            'gold_price' => 'required|numeric|min:0',
            'gold_capacity' => 'required|integer|min:1',
            'platinum_price' => 'required|numeric|min:0',
            'platinum_capacity' => 'required|integer|min:1',
        ]);

        $slug = $event->slug;
        if ($event->title !== $request->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Event::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        }

        $event->update([
            'category_id' => $request->category_id,
                        'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'strategic_location' => $request->strategic_location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'date_time' => $request->date_time,
            'banner_image' => $request->banner_image ?: $event->banner_image,
        ]);

        // Update ticket types. We adjust the remaining based on the new capacity.
        $silver = TicketType::where('event_id', $event->id)->where('name', 'Silver Ticket')->first();
        if ($silver) {
            $sold = $silver->capacity - $silver->remaining;
            $newRemaining = max(0, $request->silver_capacity - $sold);
            $silver->update([
                'price' => $request->silver_price,
                'capacity' => $request->silver_capacity,
                'remaining' => $newRemaining
            ]);
        }

        $gold = TicketType::where('event_id', $event->id)->where('name', 'Gold Ticket')->first();
        if ($gold) {
            $sold = $gold->capacity - $gold->remaining;
            $newRemaining = max(0, $request->gold_capacity - $sold);
            $gold->update([
                'price' => $request->gold_price,
                'capacity' => $request->gold_capacity,
                'remaining' => $newRemaining
            ]);
        }

        $platinum = TicketType::where('event_id', $event->id)->where('name', 'Platinum VIP')->first();
        if ($platinum) {
            $sold = $platinum->capacity - $platinum->remaining;
            $newRemaining = max(0, $request->platinum_capacity - $sold);
            $platinum->update([
                'price' => $request->platinum_price,
                'capacity' => $request->platinum_capacity,
                'remaining' => $newRemaining
            ]);
        }

        return redirect()->route('admin.events.index')->with('success', 'Event and ticket types updated successfully!');
    }

    // Admin: Destroy event
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
