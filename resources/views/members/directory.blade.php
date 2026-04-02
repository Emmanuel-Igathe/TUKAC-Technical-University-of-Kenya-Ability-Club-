@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Members Directory</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Connect with club members</p>
    </div>

    {{-- Search and Filter --}}
    <div class="mb-8 flex gap-4">
        <div class="flex-1">
            <input type="text" 
                   placeholder="Search members by name or student ID..." 
                   class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <select class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">All Roles</option>
            <option value="member">Members</option>
            <option value="executive">Executives</option>
            <option value="admin">Admins</option>
        </select>
    </div>

    {{-- Members Grid --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse (\App\Models\User::where('approval_status', 'approved')->get() as $member)
            <a href="{{ route('members.show', $member) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition group">
                {{-- Member Card Header --}}
                <div class="h-32 bg-gradient-to-br from-indigo-300 to-blue-300 dark:from-indigo-900 dark:to-blue-900 flex items-center justify-center group-hover:from-indigo-400 group-hover:to-blue-400 transition">
                    <span class="text-5xl">👤</span>
                </div>

                {{-- Member Info --}}
                <div class="p-6">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                {{ $member->name }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $member->student_id }}
                            </p>
                        </div>
                        @if ($member->isAdmin())
                            <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900 px-2 py-1 rounded">
                                Admin
                            </span>
                        @elseif ($member->isExecutive())
                            <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 px-2 py-1 rounded">
                                Executive
                            </span>
                        @endif
                    </div>

                    {{-- Member Contact --}}
                    <div class="space-y-2 mb-4 text-sm">
                        @if ($member->email)
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <span class="mr-2">📧</span>
                                <span class="truncate">{{ $member->email }}</span>
                            </div>
                        @endif
                        @if ($member->contact_details)
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <span class="mr-2">📱</span>
                                <span>{{ $member->contact_details }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Joined Date --}}
                    <p class="text-xs text-gray-500 dark:text-gray-400 pt-3 border-t border-gray-200 dark:border-gray-700">
                        Joined {{ $member->created_at->format('M d, Y') }}
                    </p>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-600 dark:text-gray-400 text-lg">
                    No approved members yet.
                </p>
            </div>
        @endforelse
    </div>

    {{-- Total Members Stats --}}
    <div class="mt-12 bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900 dark:to-blue-900 rounded-lg p-6">
        <div class="grid md:grid-cols-3 gap-6 text-center">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Approved Members</p>
                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                    {{ \App\Models\User::where('approval_status', 'approved')->count() }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Pending Approvals</p>
                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                    {{ \App\Models\User::where('approval_status', 'pending')->count() }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Club Executives</p>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                    {{ \App\Models\User::where('role', 'executive')->orWhere('role', 'admin')->count() }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
