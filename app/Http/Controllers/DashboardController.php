<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show dashboard
     */
    public function index()
    {
        $upcomingEvents = Event::upcoming()->limit(5)->get();
        $recentPosts = BlogPost::recent(5)->get();
        $totalMembers = User::where('approval_status', 'approved')->count();

        return view('dashboard', [
            'upcomingEvents' => $upcomingEvents,
            'recentPosts' => $recentPosts,
            'totalMembers' => $totalMembers,
        ]);
    }

    /**
     * Admin dashboard
     */
    public function admin()
    {
        $this->authorize('isAdmin');

        $pendingMembers = User::where('approval_status', 'pending')->count();
        $totalMembers = User::where('approval_status', 'approved')->count();
        $totalEvents = Event::count();
        $totalPosts = BlogPost::count();

        return view('admin.dashboard', [
            'pendingMembers' => $pendingMembers,
            'totalMembers' => $totalMembers,
            'totalEvents' => $totalEvents,
            'totalPosts' => $totalPosts,
        ]);
    }
}
