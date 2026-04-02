@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Back Button --}}
    <a href="{{ route('events.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline mb-6 inline-flex items-center">
        ← Back to Events
    </a>

    {{-- Event Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-8">
        <div class="h-64 bg-gradient-to-br from-indigo-300 to-blue-300 dark:from-indigo-900 dark:to-blue-900 flex items-center justify-center">
            <span class="text-9xl">📅</span>
        </div>
        
        <div class="p-8">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ $event->title }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Organized by <span class="font-semibold">{{ $event->creator->name }}</span>
                        @if ($event->creator->isAdmin())
                            <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900 px-2 py-1 rounded ml-2">Admin</span>
                        @elseif ($event->creator->isExecutive())
                            <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 px-2 py-1 rounded ml-2">Executive</span>
                        @endif
                    </p>
                </div>

                @if (Auth::user()->id === $event->created_by || Auth::user()->isAdmin())
                    <div class="flex gap-2">
                        <a href="{{ route('events.edit', $event) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Edit
                        </a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Event Details Grid --}}
            <div class="grid md:grid-cols-4 gap-4 mb-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <span class="text-3xl mr-3">📅</span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Date</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $event->date->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-3xl mr-3">⏰</span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Time</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $event->time }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-3xl mr-3">📍</span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Location</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $event->location }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-3xl mr-3">👥</span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Attendees</p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ $event->registrations->count() }}/{{ $event->capacity }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- RSVP Section --}}
            @php
                $userRsvp = Auth::user()->eventRegistrations()->where('event_id', $event->id)->first();
                $isUpcoming = $event->date >= now()->startOfDay();
            @endphp

            @if ($isUpcoming)
                <div class="flex gap-4 items-center mb-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    @if ($userRsvp)
                        <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                            <span class="text-2xl">✓</span>
                            <span class="font-semibold">You're attending! ({{ ucfirst($userRsvp->rsvp_status) }})</span>
                        </div>
                        <form action="{{ route('event-registrations.destroy', $userRsvp) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Cancel RSVP
                            </button>
                        </form>
                    @elseif ($event->registrations->count() < $event->capacity)
                        <form action="{{ route('event-registrations.store', $event) }}" method="POST">
                            @csrf
                            <div class="flex gap-2">
                                <select name="rsvp_status" class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500">
                                    <option value="yes">Yes, I'm attending</option>
                                    <option value="maybe">Maybe</option>
                                    <option value="no">Can't attend</option>
                                </select>
                                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                                    RSVP
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="w-full p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg text-red-800 dark:text-red-200">
                            This event is at full capacity. Check back later for updates!
                        </div>
                    @endif
                </div>
            @else
                <div class="w-full p-4 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-gray-200 mb-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    This event has already passed.
                </div>
            @endif
        </div>
    </div>

    {{-- Event Description --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">About This Event</h2>
        <p class="text-gray-600 dark:text-gray-400 leading-relaxed whitespace-pre-wrap">
            {{ $event->description }}
        </p>
    </div>

    {{-- Attendees List --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
            Attendees ({{ $event->registrations->count() }})
        </h2>
        
        @if ($event->registrations->count() > 0)
            <div class="space-y-4">
                @foreach ($event->registrations as $registration)
                    <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-300 to-blue-300 dark:from-indigo-900 dark:to-blue-900 rounded-full flex items-center justify-center text-xl">
                                👤
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                    {{ $registration->user->name }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $registration->user->student_id }}
                                </p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900 px-3 py-1 rounded-full">
                            {{ ucfirst($registration->rsvp_status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                No one has RSVP'd yet. Be the first!
            </p>
        @endif
    </div>
</div>
@endsection
