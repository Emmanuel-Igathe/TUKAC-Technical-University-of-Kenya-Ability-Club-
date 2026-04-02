@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Admin Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Manage club operations and member approvals</p>
    </div>

    {{-- High-Level Stats --}}
    <div class="grid md:grid-cols-5 gap-6 mb-8">
        {{-- Total Members --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Members</p>
                    <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                        {{ \App\Models\User::count() }}
                    </p>
                </div>
                <span class="text-4xl">👥</span>
            </div>
        </div>

        {{-- Pending Approvals --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Pending Approvals</p>
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                        {{ \App\Models\User::where('approval_status', 'pending')->count() }}
                    </p>
                </div>
                <span class="text-4xl">⏳</span>
            </div>
        </div>

        {{-- Total Events --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Events</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                        {{ \App\Models\Event::count() }}
                    </p>
                </div>
                <span class="text-4xl">📅</span>
            </div>
        </div>

        {{-- Blog Posts --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Blog Posts</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                        {{ \App\Models\BlogPost::count() }}
                    </p>
                </div>
                <span class="text-4xl">📰</span>
            </div>
        </div>

        {{-- Total Transactions --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Transactions</p>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                        {{ \App\Models\Transaction::count() }}
                    </p>
                </div>
                <span class="text-4xl">💰</span>
            </div>
        </div>
    </div>

    {{-- Main Admin Sections --}}
    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Pending Member Approvals --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Pending Member Approvals</h2>
                    <a href="{{ route('admin.members.pending') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                        View All →
                    </a>
                </div>

                @php
                    $pendingMembers = \App\Models\User::where('approval_status', 'pending')->take(10)->get();
                @endphp

                @forelse ($pendingMembers as $member)
                    <div class="flex items-start justify-between border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-0">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $member->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                📧 {{ $member->email }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                🎓 {{ $member->student_id }}
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                                Applied: {{ $member->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex gap-2 ml-4">
                            <form action="{{ route('admin.members.approve', $member) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                                    Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.members.reject', $member) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">
                        No pending approvals 🎉
                    </p>
                @endforelse
            </div>

            {{-- Recent Activity --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Recent Activity</h2>
                
                <div class="space-y-4">
                    {{-- Recent Events --}}
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-3">Latest Events</h3>
                        @forelse (\App\Models\Event::latest()->take(3)->get() as $event)
                            <div class="text-sm text-gray-600 dark:text-gray-400 pb-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                                <p>
                                    <span class="font-semibold">{{ $event->title }}</span> 
                                    <span class="text-xs text-gray-500">{{ $event->created_at->diffForHumans() }}</span>
                                </p>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400">No events yet</p>
                        @endforelse
                    </div>

                    {{-- Recent Blog Posts --}}
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-3">Latest Blog Posts</h3>
                        @forelse (\App\Models\BlogPost::latest()->take(3)->get() as $post)
                            <div class="text-sm text-gray-600 dark:text-gray-400 pb-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                                <p>
                                    <span class="font-semibold">{{ $post->title }}</span>
                                    <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                                </p>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400">No posts yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Admin Actions --}}
        <div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.members.pending') }}" class="block w-full p-3 bg-indigo-50 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-800 transition text-center">
                        👤 Review Members
                    </a>
                    <a href="{{ route('admin.members.assign-role') }}" class="block w-full p-3 bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition text-center">
                        🔐 Assign Roles
                    </a>
                    <a href="{{ route('events.create') }}" class="block w-full p-3 bg-green-50 dark:bg-green-900 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition text-center">
                        ➕ Create Event
                    </a>
                    <a href="{{ route('blog.create') }}" class="block w-full p-3 bg-purple-50 dark:bg-purple-900 text-purple-600 dark:text-purple-400 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800 transition text-center">
                        ✍️ Create Post
                    </a>
                    <a href="{{ route('finance.dashboard') }}" class="block w-full p-3 bg-yellow-50 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-800 transition text-center">
                        💰 Finance Dashboard
                    </a>
                </div>
            </div>

            {{-- Admin Resources --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Resources</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="{{ route('events.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            📅 All Events
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('blog.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            📰 All Blog Posts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('finance.transactions') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            💳 All Transactions
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.financial') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            📊 Financial Reports
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('members.directory') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            👥 Members Directory
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Financial Overview --}}
    @php
        $income = \App\Models\Transaction::income()->sum('amount');
        $expenses = \App\Models\Transaction::expense()->sum('amount');
        $balance = $income - $expenses;
    @endphp
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Financial Overview</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Income</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400">KES {{ number_format($income, 2) }}</p>
            </div>
            <div class="text-center p-4 bg-red-50 dark:bg-red-900 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Expenses</p>
                <p class="text-3xl font-bold text-red-600 dark:text-red-400">KES {{ number_format($expenses, 2) }}</p>
            </div>
            <div class="text-center p-4 bg-indigo-50 dark:bg-indigo-900 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400">Balance</p>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">KES {{ number_format($balance, 2) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
