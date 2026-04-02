<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    /**
     * Register user for event (RSVP)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'rsvp_status' => 'required|in:yes,no,maybe',
        ]);

        $existingRsvp = EventRegistration::where('user_id', Auth::id())
            ->where('event_id', $validated['event_id'])
            ->first();

        if ($existingRsvp) {
            $existingRsvp->update(['rsvp_status' => $validated['rsvp_status']]);
        } else {
            EventRegistration::create([
                'user_id' => Auth::id(),
                'event_id' => $validated['event_id'],
                'rsvp_status' => $validated['rsvp_status'],
            ]);
        }

        return back()->with('status', 'RSVP updated successfully!');
    }

    /**
     * Cancel RSVP
     */
    public function destroy(Event $event)
    {
        EventRegistration::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->delete();

        return back()->with('status', 'RSVP cancelled!');
    }

    /**
     * View RSVPs for event
     */
    public function show(Event $event)
    {
        $this->authorize('created', $event);

        $registrations = $event->registrations()->with('user')->get();
        return view('events.registrations', [
            'event' => $event,
            'registrations' => $registrations,
        ]);
    }
}
