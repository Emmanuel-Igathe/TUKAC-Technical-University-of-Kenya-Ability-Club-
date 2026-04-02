<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display member directory
     */
    public function directory()
    {
        $members = User::where('approval_status', 'approved')
                      ->where('id', '!=', Auth::id())
                      ->paginate(20);

        return view('members.directory', ['members' => $members]);
    }

    /**
     * Show member profile
     */
    public function show(User $user)
    {
        return view('members.profile', ['member' => $user]);
    }

    /**
     * Show current user profile
     */
    public function profile()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    /**
     * Show edit profile form
     */
    public function editProfile()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'contact_details' => 'nullable|string',
        ]);

        Auth::user()->update($validated);

        return redirect('/profile')->with('status', 'Profile updated!');
    }

    /**
     * Admin: List pending members
     */
    public function pendingMembers()
    {
        $this->authorize('isAdmin');

        $pendingMembers = User::where('approval_status', 'pending')->get();
        return view('admin.members.pending', ['members' => $pendingMembers]);
    }

    /**
     * Admin: Approve member
     */
    public function approveMember(User $user)
    {
        $this->authorize('isAdmin');

        $user->update(['approval_status' => 'approved']);

        return back()->with('status', "Member {$user->name} approved!");
    }

    /**
     * Admin: Reject member
     */
    public function rejectMember(User $user)
    {
        $this->authorize('isAdmin');

        $user->update(['approval_status' => 'rejected']);

        return back()->with('status', "Member {$user->name} rejected!");
    }

    /**
     * Admin: Assign role
     */
    public function assignRole(Request $request, User $user)
    {
        $this->authorize('isAdmin');

        $validated = $request->validate([
            'role' => 'required|in:member,executive,admin',
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('status', "Role assigned to {$user->name}!");
    }
}
