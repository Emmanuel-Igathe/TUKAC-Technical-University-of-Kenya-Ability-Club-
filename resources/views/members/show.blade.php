@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Back Button --}}
    <a href="{{ route('members.directory') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline mb-6 inline-flex items-center">
        ← Back to Members
    </a>

    {{-- Profile Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-8">
        <div class="h-32 bg-gradient-to-r from-indigo-300 to-blue-300 dark:from-indigo-900 dark:to-blue-900"></div>
        
        <div class="px-8 pb-8">
            {{-- Profile Info --}}
            <div class="flex items-end justify-between mb-6 -mt-16">
                <div class="flex items-end gap-6">
                    <div class="w-32 h-32 bg-gradient-to-br from-indigo-300 to-blue-300 dark:from-indigo-900 dark:to-blue-900 rounded-full flex items-center justify-center text-6xl border-4 border-white dark:border-gray-800">
                        👤
                    </div>
                    <div class="pb-2">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $user->name }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            Student ID: <span class="font-semibold">{{ $user->student_id }}</span>
                        </p>
                    </div>
                </div>

                @if (Auth::user()->id === $user->id)
                    <a href="{{ route('members.edit-profile') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                        Edit Profile
                    </a>
                @endif
            </div>

            {{-- Role Badge --}}
            <div class="mb-6 flex items-center gap-2">
                @if ($user->isAdmin())
                    <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900 px-3 py-1 rounded-full">
                        🔐 Admin
                    </span>
                @elseif ($user->isExecutive())
                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 px-3 py-1 rounded-full">
                        👔 Executive
                    </span>
                @else
                    <span class="text-xs font-semibold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900 px-3 py-1 rounded-full">
                        👤 Member
                    </span>
                @endif

                @if ($user->isApproved())
                    <span class="text-xs font-semibold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900 px-3 py-1 rounded-full">
                        ✓ Approved
                    </span>
                @else
                    <span class="text-xs font-semibold text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900 px-3 py-1 rounded-full">
                        ⏳ Pending Approval
                    </span>
                @endif
            </div>

            {{-- Contact Information --}}
            <div class="grid md:grid-cols-2 gap-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Contact Information</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500 dark:text-gray-400">📧</span>
                            <span class="text-gray-700 dark:text-gray-300">{{ $user->email }}</span>
                        </div>
                        @if ($user->contact_details)
                            <div class="flex items-center gap-2">
                                <span class="text-gray-500 dark:text-gray-400">📱</span>
                                <span class="text-gray-700 dark:text-gray-300">{{ $user->contact_details }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Member Since</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $user->created_at->format('M d, Y') }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        ({{ $user->created_at->diffForHumans() }})
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Activity Section --}}
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        {{-- Events Attended --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="font-bold text-gray-900 dark:text-white mb-3">Events Attended</h3>
            <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                {{ $user->eventRegistrations->count() }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Registered for events
            </p>
        </div>

        {{-- Blog Posts --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="font-bold text-gray-900 dark:text-white mb-3">Blog Posts</h3>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                {{ $user->blogPosts->count() }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Posts published
            </p>
        </div>

        {{-- Comments --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="font-bold text-gray-900 dark:text-white mb-3">Comments</h3>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                {{ $user->comments->count() }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Comments made
            </p>
        </div>
    </div>

    {{-- Recent Events --}}
    @php
        $recentEvents = $user->eventRegistrations()
            ->with('event')
            ->latest()
            ->take(5)
            ->get();
    @endphp
    @if ($recentEvents->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Recent Event Registrations</h2>
            <div class="space-y-4">
                @foreach ($recentEvents as $registration)
                    <div class="flex items-start justify-between border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0">
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                {{ $registration->event->title }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                📅 {{ $registration->event->date->format('M d, Y') }} at {{ $registration->event->time }}
                            </p>
                        </div>
                        <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900 px-3 py-1 rounded">
                            {{ ucfirst($registration->rsvp_status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Recent Blog Posts --}}
    @php
        $recentPosts = $user->blogPosts()
            ->latest()
            ->take(5)
            ->get();
    @endphp
    @if ($recentPosts->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Recent Blog Posts</h2>
            <div class="space-y-4">
                @foreach ($recentPosts as $post)
                    <div class="flex items-start justify-between border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0">
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400">
                                <a href="{{ route('blog.show', $post) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $post->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900 px-3 py-1 rounded">
                            {{ ucfirst($post->category) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
