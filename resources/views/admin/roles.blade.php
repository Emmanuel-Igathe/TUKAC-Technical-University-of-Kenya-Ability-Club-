@extends('layouts.app')

@section('title', 'Manage Roles - TUK Ability Club')
@section('header', 'Manage Roles & Permissions')
@section('subtitle', '<p class="text-gray-600">Configure user roles and permissions for the club</p>')

@section('content')
<div class="space-y-6">
    <!-- Roles Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Admin Role -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-red-600">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-crown text-red-600 mr-2"></i>Admin
                </h3>
                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                    {{ $roleCounts['admin'] ?? 0 }} members
                </span>
            </div>
            <p class="text-gray-600 text-sm mb-4">Full access to all club functions and member management</p>
            
            <div class="bg-red-50 rounded-lg p-4 mb-4">
                <h4 class="font-semibold text-gray-800 mb-2">Permissions:</h4>
                <ul class="text-sm text-gray-700 space-y-1">
                    <li><i class="fas fa-check text-green-600 mr-2"></i>View all members</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Approve/Reject members</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Assign roles</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Manage finances</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Moderate content</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Generate reports</li>
                </ul>
            </div>

            <a href="{{ route('admin.manage-role', 'admin') }}" class="inline-block px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Configure
            </a>
        </div>

        <!-- Executive Role -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-yellow-600">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-star text-yellow-600 mr-2"></i>Executive
                </h3>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                    {{ $roleCounts['executive'] ?? 0 }} members
                </span>
            </div>
            <p class="text-gray-600 text-sm mb-4">Leadership access to create events, manage finances, and moderate content</p>
            
            <div class="bg-yellow-50 rounded-lg p-4 mb-4">
                <h4 class="font-semibold text-gray-800 mb-2">Permissions:</h4>
                <ul class="text-sm text-gray-700 space-y-1">
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Create events</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Record transactions</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Approve blog posts</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>View financial reports</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>View member list</li>
                    <li><i class="fas fa-times text-red-600 mr-2"></i>Manage admin roles</li>
                </ul>
            </div>

            <a href="{{ route('admin.manage-role', 'executive') }}" class="inline-block px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Configure
            </a>
        </div>

        <!-- Member Role -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-blue-600">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-user text-blue-600 mr-2"></i>Member
                </h3>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                    {{ $roleCounts['member'] ?? 0 }} members
                </span>
            </div>
            <p class="text-gray-600 text-sm mb-4">Standard access to view events, blog posts, and join activities</p>
            
            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                <h4 class="font-semibold text-gray-800 mb-2">Permissions:</h4>
                <ul class="text-sm text-gray-700 space-y-1">
                    <li><i class="fas fa-check text-green-600 mr-2"></i>View events</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>RSVP to events</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Read blog posts</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Comment on posts</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>View member directory</li>
                    <li><i class="fas fa-times text-red-600 mr-2"></i>Access admin panel</li>
                </ul>
            </div>

            <a href="{{ route('admin.manage-role', 'member') }}" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Configure
            </a>
        </div>
    </div>

    <!-- Bulk Role Assignment -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-users-cog text-blue-600 mr-2"></i>Bulk Role Assignment
        </h3>
        
        <form method="POST" action="{{ route('admin.bulk-assign-roles') }}" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Select Members -->
                <div>
                    <label for="members" class="block text-sm font-medium text-gray-700 mb-1">Select Members</label>
                    <select id="members" name="members[]" multiple class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" size="6">
                        @foreach($allMembers ?? [] as $member)
                            <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->student_id ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple members</p>
                </div>

                <!-- Select Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Assign Role</label>
                    <select id="role" name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select a role</option>
                        <option value="member">Member</option>
                        <option value="executive">Executive</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex flex-col justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
                        <i class="fas fa-check mr-2"></i>Assign Roles
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Role Activity Log -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-history text-blue-600 mr-2"></i>Recent Role Changes
        </h3>

        <div class="space-y-3">
            @forelse($roleChanges ?? [] as $change)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div>
                        <p class="font-semibold text-gray-800">
                            {{ $change->user->name }} changed to 
                            <span class="px-2 py-1 rounded-full text-xs font-bold
                                {{ $change->new_role === 'admin' ? 'bg-red-100 text-red-800' : ($change->new_role === 'executive' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst($change->new_role) }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-600">Previous: <span class="font-semibold">{{ ucfirst($change->old_role) }}</span></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">{{ $change->changed_by->name }}</p>
                        <p class="text-xs text-gray-500">{{ $change->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-6">No role changes recorded yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
