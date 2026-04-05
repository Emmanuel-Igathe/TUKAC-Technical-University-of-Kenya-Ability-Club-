<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display list of all events
     */
    public function index()
    {
        $upcomingEvents = Event::upcoming()->paginate(10);
        return view('events.index', ['events' => $upcomingEvents]);
    }

    /**
     * Show create event form
     */
    public function create()
    {
        $this->authorize('isExecutive');
        return view('events.create');
    }

    /**
     * Store new event
     */
    public function store(Request $request)
    {
        $this->authorize('isExecutive');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'location' => 'required|string',
            'capacity' => 'required|integer|min:1',
        ]);

        Event::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        return redirect('/events')->with('status', 'Event created successfully!');
    }

    /**
     * Show event details
     */
    public function show(Event $event)
    {
        $isAttendee = Auth::check() ? $event->isAttendee(Auth::id()) : false;
        $registrations = $event->registrations()->count();

        return view('events.show', [
            'event' => $event,
            'isAttendee' => $isAttendee,
            'registrations' => $registrations,
        ]);
    }

    /**
     * Show edit form
     */
    public function edit(Event $event)
    {
        $this->authorizeOwner($event);
        return view('events.edit', ['event' => $event]);
    }

    /**
     * Update event
     */
    public function update(Request $request, Event $event)
    {
        $this->authorizeOwner($event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'capacity' => 'required|integer|min:1',
        ]);

        $event->update($validated);

        return redirect("/events/{$event->id}")->with('status', 'Event updated successfully!');
    }

    /**
     * Delete event
     */
    public function destroy(Event $event)
    {
        $this->authorizeOwner($event);
        $event->delete();

        return redirect('/events')->with('status', 'Event deleted successfully!');
    }

    /**
     * Calendar view
     */
    public function calendar()
    {
        $events = Event::upcoming()->get();
        return view('events.calendar', ['events' => $events]);
    }

    private function authorizeOwner(Event $event)
    {
        if (Auth::id() !== $event->created_by && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
    }
}
