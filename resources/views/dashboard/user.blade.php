@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Section with Gradient -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 dark:from-indigo-700 dark:to-blue-700 rounded-2xl shadow-xl p-8 text-white overflow-hidden relative">
        <div class="absolute top-0 right-0 opacity-10 text-8xl">🎓</div>
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-indigo-100 text-lg">Student ID: <span class="font-mono font-semibold">{{ Auth::user()->student_id }}</span> • Role: <span class="font-semibold capitalize">{{ Auth::user()->role }}</span></p>
        </div>
    </div>

    <!-- Status Alerts -->
    @if (Auth::user()->approval_status === 'pending')
        <div class="bg-amber-50 dark:bg-amber-950 border-2 border-amber-200 dark:border-amber-800 rounded-xl p-6 flex items-start gap-4 animate-pulse">
            <span class="text-3xl flex-shrink-0 pt-1">⏳</span>
            <div>
                <h3 class="font-semibold text-amber-900 dark:text-amber-100 mb-1">Account Pending Approval</h3>
                <p class="text-amber-700 dark:text-amber-200 text-sm">Your account is being reviewed by our admin team. You'll get full access once approved!</p>
            </div>
        </div>
    @elseif (Auth::user()->approval_status === 'rejected')
        <div class="bg-red-50 dark:bg-red-950 border-2 border-red-200 dark:border-red-800 rounded-xl p-6 flex items-start gap-4">
            <span class="text-3xl flex-shrink-0 pt-1">❌</span>
            <div>
                <h3 class="font-semibold text-red-900 dark:text-red-100 mb-1">Account Rejected</h3>
                <p class="text-red-700 dark:text-red-200 text-sm">Your application was rejected. Please <a href="#" class="underline font-semibold hover:text-red-800 dark:hover:text-red-100">contact support</a> for more information.</p>
            </div>
        </div>
    @elseif (Auth::user()->approval_status === 'pending')
        <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
            <p class="text-yellow-800 dark:text-yellow-200">
                ⏳ Your account is pending admin approval. You'll get full access once approved.
            </p>
        </div>
    @elseif (Auth::user()->approval_status === 'rejected')
        <div class="mt-4 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg">
            <p class="text-red-800 dark:text-red-200">
                ❌ Your account has been rejected. Please contact admin for more information.
            </p>
        @if (Auth::user()->approval_status === 'pending')
            <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                <p class="text-yellow-800 dark:text-yellow-200">
                    ⏳ Your account is pending admin approval. You'll get full access once approved.
                </p>
            </div>
        @elseif (Auth::user()->approval_status === 'rejected')
            <div class="mt-4 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg">
                <p class="text-red-800 dark:text-red-200">
                    ❌ Your account has been rejected. Please contact admin for more information.
                </p>
            </div>
        @endif
    </div>

    {{-- Stats Section --}}
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        {{-- Upcoming Events Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Upcoming Events</p>
                    <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                        {{ \App\Models\Event::upcoming()->count() }}
                    </p>
                </div>
                <span class="text-4xl">📅</span>
            </div>
        </div>

        {{-- Your RSVPs Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Your RSVPs</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                        {{ Auth::user()->eventRegistrations->count() }}
                    </p>
                </div>
                <span class="text-4xl">✅</span>
            </div>
        </div>

        {{-- Blog Posts Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Latest Posts</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                        {{ \App\Models\BlogPost::recent()->count() }}
                    </p>
                </div>
                <span class="text-4xl">📰</span>
            </div>
        </div>

        {{-- Members Count Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Club Members</p>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                        {{ \App\Models\User::where('approval_status', 'approved')->count() }}
                    </p>
                </div>
                <span class="text-4xl">👥</span>
            </div>
        </div>
    </div>

    {{-- Your Upcoming Events --}}
    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Your Upcoming Events</h2>
                    <a href="{{ route('events.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                        View All →
                    </a>
                </div>

                @php
                    $yourEvents = Auth::user()->eventRegistrations()
                        ->whereHas('event', function($q) { $q->upcoming(); })
                        ->with('event')
                        ->get()
                        ->take(5);
                @endphp

                @forelse ($yourEvents as $registration)
                    <div class="flex items-start justify-between border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-0">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                {{ $registration->event->title }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                📅 {{ $registration->event->date->format('M d, Y') }} at {{ $registration->event->time }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                📍 {{ $registration->event->location }}
                            </p>
                            <span class="inline-block mt-2 text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900 px-3 py-1 rounded-full">
                                Status: {{ ucfirst($registration->rsvp_status) }}
                            </span>
                        </div>
                        <a href="{{ route('events.show', $registration->event) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline ml-4">
                            View →
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">
                        No upcoming events. <a href="{{ route('events.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Browse events</a>
                    </p>
                @endforelse
            </div>
        </div>

        {{-- Latest Blog Posts Sidebar --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Latest Updates</h2>
                <a href="{{ route('blog.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-xs">
                    All →
                </a>
            </div>

            @forelse (\App\Models\BlogPost::recent()->take(5)->get() as $post)
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700 last:border-0">
                    <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase">
                        {{ ucfirst($post->category) }}
                    </span>
                    <h3 class="font-semibold text-gray-900 dark:text-white mt-1 line-clamp-2">
                        {{ $post->title }}
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        {{ $post->created_at->format('M d, Y') }}
                    </p>
                    <a href="{{ route('blog.show', $post) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-xs font-semibold mt-2 inline-block">
                        Read More →
                    </a>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm text-center py-4">
                    No posts yet
                </p>
            @endforelse
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="mt-8 bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900 dark:to-blue-900 rounded-lg p-6">
        <h3 class="font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid md:grid-cols-3 gap-4">
            <a href="{{ route('events.index') }}" class="p-4 bg-white dark:bg-gray-800 rounded-lg hover:shadow-lg transition text-center">
                <p class="text-2xl mb-2">📅</p>
                <p class="font-semibold text-gray-900 dark:text-white text-sm">Browse Events</p>
            </a>
            <a href="{{ route('blog.index') }}" class="p-4 bg-white dark:bg-gray-800 rounded-lg hover:shadow-lg transition text-center">
                <p class="text-2xl mb-2">📰</p>
                <p class="font-semibold text-gray-900 dark:text-white text-sm">Read Blog Posts</p>
            </a>
            <a href="{{ route('members.directory') }}" class="p-4 bg-white dark:bg-gray-800 rounded-lg hover:shadow-lg transition text-center">
                <p class="text-2xl mb-2">👥</p>
                <p class="font-semibold text-gray-900 dark:text-white text-sm">Members Directory</p>
            </a>
        </div>
    </div>
</div>
@endsection
