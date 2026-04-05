@extends('layouts.app')

@section('title', 'Manage Members - TUK Ability Club')
@section('header', 'Manage Members')
@section('subtitle', '<p class="text-gray-600">View and manage all club members</p>')

@section('content')
<div class="space-y-6">
    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <!-- Search -->
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input 
                    type="text" 
                    id="search" 
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name, email, or student ID..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Filter by Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select id="role" name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Roles</option>
                    <option value="member" {{ request('role') === 'member' ? 'selected' : '' }}>Member</option>
                    <option value="executive" {{ request('role') === 'executive' ? 'selected' : '' }}>Executive</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <!-- Filter by Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Apply Filter -->
            <div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Member</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Student ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Joined</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($members ?? [] as $member)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $member->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800">
                            {{ $member->student_id ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $member->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $member->role === 'admin' ? 'bg-red-100 text-red-800' : ($member->role === 'executive' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst($member->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($member->approval_status === 'approved')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-check mr-1"></i>Approved
                                </span>
                            @elseif($member->approval_status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-hourglass-half mr-1"></i>Pending
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-times mr-1"></i>Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $member->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <!-- View Profile -->
                                <a href="{{ route('profile.show', $member) }}" class="text-blue-600 hover:text-blue-700" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit Member -->
                                <a href="{{ route('admin.members.edit', $member) }}" class="text-yellow-600 hover:text-yellow-700" title="Edit Member">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Change Role (Dropdown) -->
                                <div class="relative group">
                                    <button class="text-purple-600 hover:text-purple-700" title="Change Role">
                                        <i class="fas fa-shield-alt"></i>
                                    </button>
                                    <div class="absolute right-0 w-32 bg-white rounded-lg shadow-xl opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-opacity duration-200 z-50">
                                        <form action="{{ route('admin.members.update-role', $member) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="role" value="member" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm first:rounded-t-lg">
                                                Member
                                            </button>
                                            <button type="submit" name="role" value="executive" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                                Executive
                                            </button>
                                            <button type="submit" name="role" value="admin" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm last:rounded-b-lg">
                                                Admin
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Delete Member -->
                                <form action="{{ route('admin.members.destroy', $member) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this member?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700" title="Delete Member">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <i class="fas fa-search text-gray-300 text-5xl mb-4 block"></i>
                            <p class="text-gray-500">No members found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($members) && $members->hasPages())
    <div class="flex justify-center">
        {{ $members->links() }}
    </div>
    @endif

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <p class="text-gray-600 text-sm font-semibold uppercase">Total Members</p>
            <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['total_members'] ?? 0 }}</h3>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <p class="text-gray-600 text-sm font-semibold uppercase">Approved</p>
            <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $stats['approved'] ?? 0 }}</h3>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <p class="text-gray-600 text-sm font-semibold uppercase">Pending</p>
            <h3 class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pending'] ?? 0 }}</h3>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <p class="text-gray-600 text-sm font-semibold uppercase">Executives</p>
            <h3 class="text-3xl font-bold text-purple-600 mt-2">{{ $stats['executives'] ?? 0 }}</h3>
        </div>
    </div>
</div>
@endsection
