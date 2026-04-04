@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-700 dark:to-cyan-700 rounded-2xl shadow-xl p-8 text-white overflow-hidden relative">
        <div class="absolute top-0 right-0 opacity-10 text-8xl">📅</div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-2">📅 Club Events</h1>
                <p class="text-blue-100 text-lg">Discover and join upcoming club activities</p>
            </div>
            @if (Auth::user()->isExecutive() || Auth::user()->isAdmin())
                <a href="{{ route('events.create') }}" class="px-6 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition font-semibold">
                    + Create Event
                </a>
            @endif
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-4">
        <input type="search" placeholder="Search events..." class="flex-1 min-w-xs px-4 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-lg focus:border-blue-500 dark:focus:border-blue-400 outline-none text-gray-900 dark:text-white transition">
        <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">🔍 Search</button>
    </div>

    <!-- Upcoming Events Grid -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">🚀 Upcoming Events</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse (\App\Models\Event::upcoming()->orderBy('date')->get() as $event)
                <a href="{{ route('events.show', $event) }}" class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition group">
                    <div class="h-48 bg-gradient-to-br from-blue-300 to-cyan-300 dark:from-blue-900 dark:to-cyan-900 flex items-center justify-center text-6xl opacity-30 group-hover:scale-110 transition">📅</div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-bold text-blue-600 dark:text-blue-400 uppercase bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded">
                                {{ $event->date->format('M d') }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $event->date->format('Y') }}</span>
                        </div>
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white group-hover:text-blue-600 line-clamp-2 mb-2">
                            {{ $event->title }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">📍 {{ $event->location }}</p>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-700">
                            <span class="text-xs text-gray-500">👥 {{ $event->registrations->count() }} attending</span>
                            <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">View →</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-4xl mb-3 opacity-30">📭</p>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No upcoming events</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Past Events -->
    @if(\App\Models\Event::past()->count() > 0)
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">📜 Past Events</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach(\App\Models\Event::past()->take(6) as $event)
                    <a href="{{ route('events.show', $event) }}" class="bg-slate-50 dark:bg-slate-800/50 rounded-xl shadow border border-slate-200 dark:border-slate-700 overflow-hidden opacity-75 hover:opacity-100 transition group">
                        <div class="h-40 bg-gray-300 dark:bg-slate-700 flex items-center justify-center text-4xl opacity-20">📅</div>
                        <div class="p-6">
                            <span class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">{{ $event->date->format('M d, Y') }}</span>
                            <h3 class="font-bold text-gray-700 dark:text-gray-300 line-clamp-2 mt-2">{{ $event->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

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
