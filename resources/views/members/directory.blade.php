@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 dark:from-purple-700 dark:to-pink-700 rounded-2xl shadow-xl p-8 text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-2">👥 Members Directory</h1>
        <p class="text-purple-100 text-lg">Connect with club members and build meaningful relationships</p>
    </div>

    <!-- Search and Filter -->
    <div class="grid md:grid-cols-3 gap-4">
        <input type="text" 
               placeholder="Search members by name..." 
               class="md:col-span-2 px-4 py-3 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
               dark:bg-slate-700 dark:text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 transition">
        <select class="px-4 py-3 border-2 border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 transition">
            <option value="">All Roles</option>
            <option value="member">Members</option>
            <option value="executive">Executives</option>
            <option value="admin">Admins</option>
        </select>
    </div>

    <!-- Members Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse (\App\Models\User::where('approval_status', 'approved')->get() as $member)
            <a href="{{ route('members.show', $member) }}" class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition group">
                <!-- Member Card Header -->
                <div class="h-32 bg-gradient-to-br from-purple-300 to-pink-300 dark:from-purple-900 dark:to-pink-900 flex items-center justify-center text-5xl group-hover:scale-110 transition">👤</div>

                <!-- Member Info -->
                <div class="p-6">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition">{{ $member->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $member->student_id }}</p>
                        </div>
                        @if ($member->isAdmin())
                            <span class="text-xs font-semibold px-2 py-1 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300">🔐 Admin</span>
                        @elseif ($member->isExecutive())
                            <span class="text-xs font-semibold px-2 py-1 rounded-full bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-300">⭐ Exec</span>
                        @endif
                    </div>

                    <!-- Member Contact -->
                    <div class="space-y-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                        @if ($member->email)
                            <div class="flex items-center gap-2 truncate">📧 <span class="truncate">{{ $member->email }}</span></div>
                        @endif
                        @if ($member->contact_details)
                            <div class="flex items-center gap-2">📱 {{ $member->contact_details }}</div>
                        @endif
                    </div>

                    <!-- Joined Date -->
                    <p class="text-xs text-gray-500 dark:text-gray-400 pt-3 border-t border-slate-200 dark:border-slate-700">
                        Joined {{ $member->created_at->format('M d, Y') }}
                    </p>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-600 dark:text-gray-400 text-lg">No approved members yet.</p>
            </div>
        @endforelse
    </div>

    <!-- Stats -->
    <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-950 dark:to-pink-950 rounded-2xl border border-purple-200 dark:border-purple-800 p-8">
        <div class="grid md:grid-cols-3 gap-6 text-center">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">👥 Total Members</p>
                <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">{{ \App\Models\User::where('approval_status', 'approved')->count() }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">⏳ Pending</p>
                <p class="text-4xl font-bold text-yellow-600 dark:text-yellow-400">{{ \App\Models\User::where('approval_status', 'pending')->count() }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">⭐ Executives</p>
                <p class="text-4xl font-bold text-pink-600 dark:text-pink-400">{{ \App\Models\User::where('role', 'executive')->orWhere('role', 'admin')->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
