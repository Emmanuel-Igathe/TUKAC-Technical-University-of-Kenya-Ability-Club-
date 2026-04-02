@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Header with Create Button --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Events</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Discover and RSVP to club events</p>
        </div>
        @if (Auth::user()->isExecutive() || Auth::user()->isAdmin())
            <a href="{{ route('events.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                + Create Event
            </a>
        @endif
    </div>

    {{-- Filter and Search --}}
    <div class="mb-8 flex gap-4">
        <div class="flex-1">
            <input type="text" 
                   placeholder="Search events..." 
                   class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                📅 Upcoming
            </button>
            <button class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                📋 Calendar
            </button>
        </div>
    </div>

    {{-- Upcoming Events Grid --}}
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Upcoming Events</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse (\App\Models\Event::upcoming()->orderBy('date')->get() as $event)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-indigo-300 to-blue-300 dark:from-indigo-900 dark:to-blue-900 flex items-center justify-center">
                        <span class="text-6xl">📅</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                📅 {{ $event->date->format('M d, Y') }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                ⏰ {{ $event->time }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
                            {{ $event->title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                            {{ $event->description }}
                        </p>
                        <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm mb-3">
                            <span>📍</span>
                            <span class="ml-2">{{ $event->location }}</span>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                👥 {{ $event->registrations->count() }}/{{ $event->capacity }} attending
                            </span>
                            @if ($event->registrations->count() >= $event->capacity)
                                <span class="text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900 px-2 py-1 rounded">
                                    Full
                                </span>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('events.show', $event) }}" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-center font-semibold text-sm">
                                View Details
                            </a>
                            @php
                                $userRsvp = Auth::user()->eventRegistrations()->where('event_id', $event->id)->first();
                            @endphp
                            @if ($userRsvp)
                                <button disabled class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-lg text-sm font-semibold">
                                    ✓ RSVP'd
                                </button>
                            @elseif ($event->registrations->count() < $event->capacity)
                                <form action="{{ route('event-registrations.store', $event) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold">
                                        RSVP
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        No upcoming events. Check back soon!
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Past Events --}}
    @php
        $pastEvents = \App\Models\Event::past()->orderByDesc('date')->take(6)->get();
    @endphp
    @if ($pastEvents->count() > 0)
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Past Events</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($pastEvents as $event)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow opacity-75 overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center">
                            <span class="text-6xl opacity-50">📅</span>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                                    📅 {{ $event->date->format('M d, Y') }}
                                </span>
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded">
                                    Completed
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                {{ $event->title }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                👥 {{ $event->registrations->count() }} attended
                            </p>
                            <a href="{{ route('events.show', $event) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-semibold">
                                View Details →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
