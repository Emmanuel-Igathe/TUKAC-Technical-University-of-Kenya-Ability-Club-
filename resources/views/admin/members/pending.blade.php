@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Pending Member Approvals</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Review and approve new member registrations</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Pending Approvals</p>
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                        {{ $pending_count }}
                    </p>
                </div>
                <span class="text-5xl">⏳</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Approved Members</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                        {{ $approved_count }}
                    </p>
                </div>
                <span class="text-5xl">✓</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Rejected Members</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">
                        {{ $rejected_count }}
                    </p>
                </div>
                <span class="text-5xl">✕</span>
            </div>
        </div>
    </div>

    {{-- Pending Members List --}}
    @if ($pending_members->count() > 0)
        <div class="space-y-4">
            @foreach ($pending_members as $member)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $member->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    📧 {{ $member->email }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    🎓 {{ $member->student_id }}
                                </p>
                                @if ($member->contact_details)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        📱 {{ $member->contact_details }}
                                    </p>
                                @endif
                            </div>

                            <div class="text-right">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Applied: {{ $member->created_at->format('M d, Y \a\t H:i') }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    ({{ $member->created_at->diffForHumans() }})
                                </p>
                            </div>
                        </div>

                        {{-- Member Details --}}
                        <div class="grid md:grid-cols-4 gap-4 mb-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                <p class="font-semibold text-yellow-600 dark:text-yellow-400 mt-1">🔄 Pending</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Events</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">0</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Requests</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">0</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Warnings</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">0</p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex gap-3 justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                            <form action="{{ route('admin.members.reject', $member) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Reject {{ $member->name }}?\n\nThis cannot be undone.');"
                                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                                    ✕ Reject
                                </button>
                            </form>
                            <form action="{{ route('admin.members.approve', $member) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                                    ✓ Approve
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-12 text-center">
            <p class="text-6xl mb-4">🎉</p>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">All Caught Up!</h3>
            <p class="text-gray-600 dark:text-gray-400">
                No pending member approvals. All applications have been reviewed.
            </p>
        </div>
    @endif

    {{-- Approved Members Summary --}}
    @if ($approved_members->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Recently Approved</h2>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach ($approved_members->take(6) as $member)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $member->name }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $member->student_id }}</p>
                            </div>
                            <span class="text-xs font-semibold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900 px-3 py-1 rounded-full">
                                ✓ Approved
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            Approved: {{ $member->updated_at->format('M d, Y') }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
