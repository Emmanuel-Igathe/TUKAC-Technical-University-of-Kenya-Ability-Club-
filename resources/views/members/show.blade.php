@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Profile Header -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-700">
        <!-- Header Background -->
        <div class="h-32 bg-gradient-to-r from-purple-400 to-pink-400 dark:from-purple-900 dark:to-pink-900"></div>
        
        <!-- Profile Content -->
        <div class="px-8 pb-8">
            <!-- Profile Info -->
            <div class="flex items-end justify-between mb-6 -mt-16">
                <div class="flex items-end gap-6">
                    <div class="w-32 h-32 bg-gradient-to-br from-purple-300 to-pink-300 dark:from-purple-900 dark:to-pink-900 rounded-full flex items-center justify-center text-6xl border-4 border-white dark:border-slate-800 shadow-lg">👤</div>
                    <div class="pb-2">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Student ID: <span class="font-semibold">{{ $user->student_id }}</span></p>
                    </div>
                </div>

                @if (Auth::user()->id === $user->id)
                    <a href="{{ route('members.edit-profile') }}" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition font-semibold">
                        ✏️ Edit Profile
                    </a>
                @endif
            </div>

            <!-- Role Badges -->
            <div class="mb-6 flex flex-wrap gap-2">
                @if ($user->isAdmin())
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300">🔐 Admin</span>
                @elseif ($user->isExecutive())
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-300">⭐ Executive</span>
                @else
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300">👤 Member</span>
                @endif

                @if ($user->isApproved())
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300">✓ Approved</span>
                @else
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300">⏳ Pending</span>
                @endif
            </div>

            <!-- Contact Information -->
            <div class="grid md:grid-cols-2 gap-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">📧 Contact Information</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span>Email:</span>
                            <span class="text-gray-700 dark:text-gray-300">{{ $user->email }}</span>
                        </div>
                        @if ($user->contact_details)
                            <div class="flex items-center gap-2">
                                <span>📱</span>
                                <span class="text-gray-700 dark:text-gray-300">{{ $user->contact_details }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">📅 Member Since</h3>
                    <p class="text-gray-700 dark:text-gray-300 font-semibold">{{ $user->created_at->format('M d, Y') }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">({{ $user->created_at->diffForHumans() }})</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6 hover:shadow-xl hover:-translate-y-1 transition">
            <h3 class="font-bold text-gray-900 dark:text-white mb-3">📅 Events</h3>
            <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">{{ $user->eventRegistrations->count() }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Events attended</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6 hover:shadow-xl hover:-translate-y-1 transition">
            <h3 class="font-bold text-gray-900 dark:text-white mb-3">📝 Posts</h3>
            <p class="text-4xl font-bold text-pink-600 dark:text-pink-400">{{ $user->blogPosts->count() }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Blog posts created</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6 hover:shadow-xl hover:-translate-y-1 transition">
            <h3 class="font-bold text-gray-900 dark:text-white mb-3">💬 Comments</h3>
            <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">{{ $user->comments->count() }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Comments made</p>
        </div>
    </div>

    <!-- Recent Event Registrations -->
    @php
        $recentEvents = $user->eventRegistrations()
            ->with('event')
            ->latest()
            ->take(5)
            ->get();
    @endphp
    @if ($recentEvents->count() > 0)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">📅 Recent Event Registrations</h2>
            <div class="space-y-4">
                @foreach ($recentEvents as $registration)
                    <div class="flex items-start justify-between border-b border-slate-200 dark:border-slate-700 pb-4 last:border-0 hover:bg-slate-50 dark:hover:bg-slate-700/50 p-3 rounded transition">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $registration->event->title }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">📅 {{ $registration->event->date->format('M d, Y') }} at {{ $registration->event->time }}</p>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300">{{ ucfirst($registration->rsvp_status) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Blog Posts -->
    @php
        $recentPosts = $user->blogPosts()
            ->latest()
            ->take(5)
            ->get();
    @endphp
    @if ($recentPosts->count() > 0)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">📝 Recent Blog Posts</h2>
            <div class="space-y-4">
                @foreach ($recentPosts as $post)
                    <div class="flex items-start justify-between border-b border-slate-200 dark:border-slate-700 pb-4 last:border-0 hover:bg-slate-50 dark:hover:bg-slate-700/50 p-3 rounded transition">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-white hover:text-purple-600 dark:hover:text-purple-400 transition">
                                <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $post->created_at->format('M d, Y') }}</p>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-300 ml-4">{{ ucfirst($post->category) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
