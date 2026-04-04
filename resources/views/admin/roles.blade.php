@extends('layouts.app')

@section('title', 'Manage Roles - TUK Ability Club')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-red-600 to-orange-600 dark:from-red-700 dark:to-orange-700 rounded-2xl shadow-xl p-8 text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-2">🔐 Manage Roles & Permissions</h1>
        <p class="text-red-100 text-lg">Configure user roles and access levels for the club</p>
    </div>

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Admin Role -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border-t-4 border-red-600 dark:border-red-500 overflow-hidden hover:shadow-xl transition">
            <div class="bg-red-50 dark:bg-red-950/30 p-6 border-b border-red-200 dark:border-red-800">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        👑 Admin
                    </h3>
                    <span class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-full text-xs font-semibold">
                        {{ $roleCounts['admin'] ?? 0 }}
                    </span>
                </div>
                <p class="text-gray-700 dark:text-gray-300 text-sm">Full system access & management</p>
            </div>
            <div class="p-6 space-y-3">
                <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                    <li>✓ View all members</li>
                    <li>✓ Approve members</li>
                    <li>✓ Assign roles</li>
                    <li>✓ Manage finances</li>
                    <li>✓ Moderate content</li>
                </ul>
                <a href="{{ route('admin.manage-role', 'admin') }}" class="block w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg text-center transition">
                    ⚙️ Configure
                </a>
            </div>
        </div>

        <!-- Executive Role -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border-t-4 border-yellow-600 dark:border-yellow-500 overflow-hidden hover:shadow-xl transition">
            <div class="bg-yellow-50 dark:bg-yellow-950/30 p-6 border-b border-yellow-200 dark:border-yellow-800">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        ⭐ Executive
                    </h3>
                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full text-xs font-semibold">
                        {{ $roleCounts['executive'] ?? 0 }}
                    </span>
                </div>
                <p class="text-gray-700 dark:text-gray-300 text-sm">Leadership & event management</p>
            </div>
            <div class="p-6 space-y-3">
                <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                    <li>✓ Create events</li>
                    <li>✓ Record transactions</li>
                    <li>✓ Approve blog posts</li>
                    <li>✓ View financial reports</li>
                    <li>✗ Manage admin roles</li>
                </ul>
                <a href="{{ route('admin.manage-role', 'executive') }}" class="block w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg text-center transition">
                    ⚙️ Configure
                </a>
            </div>
        </div>

        <!-- Member Role -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border-t-4 border-blue-600 dark:border-blue-500 overflow-hidden hover:shadow-xl transition">
            <div class="bg-blue-50 dark:bg-blue-950/30 p-6 border-b border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        👤 Member
                    </h3>
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-xs font-semibold">
                        {{ $roleCounts['member'] ?? 0 }}
                    </span>
                </div>
                <p class="text-gray-700 dark:text-gray-300 text-sm">Standard member access</p>
            </div>
            <div class="p-6 space-y-3">
                <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                    <li>✓ View events</li>
                    <li>✓ RSVP to events</li>
                    <li>✓ View blog posts</li>
                    <li>✓ Comment on posts</li>
                    <li>✗ Create events</li>
                </ul>
                <a href="{{ route('admin.manage-role', 'member') }}" class="block w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-center transition">
                    ⚙️ Configure
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
