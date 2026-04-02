<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

// Public routes
Route::get('/', function () {
    $upcomingEvents = \App\Models\Event::upcoming()->limit(3)->get();
    $recentPosts = \App\Models\BlogPost::recent(3)->get();
    return view('welcome', ['upcomingEvents' => $upcomingEvents, 'recentPosts' => $recentPosts]);
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Protected routes (authentication required)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // Event Registrations (RSVP)
    Route::post('/events/{event}/register', [EventRegistrationController::class, 'store'])->name('events.register');
    Route::delete('/events/{event}/register', [EventRegistrationController::class, 'destroy'])->name('events.register.destroy');
    Route::get('/events/{event}/registrations', [EventRegistrationController::class, 'show'])->name('events.registrations');

    // Blog
    Route::get('/blog', [BlogPostController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [BlogPostController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogPostController::class, 'store'])->name('blog.store');
    Route::get('/blog/{post}', [BlogPostController::class, 'show'])->name('blog.show');
    Route::get('/blog/{post}/edit', [BlogPostController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post}', [BlogPostController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post}', [BlogPostController::class, 'destroy'])->name('blog.destroy');

    // Comments
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Finance
    Route::get('/finance', [TransactionController::class, 'dashboard'])->name('finance.dashboard');
    Route::get('/finance/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/finance/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/finance/transactions', [TransactionController::class, 'store'])->name('transactions.store');

    // Member Directory
    Route::get('/members', [UserController::class, 'directory'])->name('members.directory');
    Route::get('/members/{user}', [UserController::class, 'show'])->name('members.show');

    // User Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');
        Route::get('/admin/members/pending', [UserController::class, 'pendingMembers'])->name('admin.members.pending');
        Route::post('/admin/members/{user}/approve', [UserController::class, 'approveMember'])->name('admin.members.approve');
        Route::post('/admin/members/{user}/reject', [UserController::class, 'rejectMember'])->name('admin.members.reject');
        Route::post('/admin/members/{user}/role', [UserController::class, 'assignRole'])->name('admin.members.role');
    });

    // Reports
    Route::middleware('executive')->group(function () {
        Route::get('/reports/financial', [ReportController::class, 'financialReport'])->name('reports.financial');
        Route::get('/reports/export/transactions', [ReportController::class, 'exportTransactions'])->name('reports.export.transactions');
    });
});

