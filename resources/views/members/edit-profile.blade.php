@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 dark:from-purple-700 dark:to-pink-700 rounded-2xl shadow-xl p-8 text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-2">✏️ Edit Profile</h1>
        <p class="text-purple-100 text-lg">Update your account information</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-8 max-w-4xl">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-950 border-2 border-red-300 dark:border-red-800 rounded-lg">
                <h3 class="font-semibold text-red-900 dark:text-red-200 mb-2">⚠️ Validation Errors:</h3>
                <ul class="list-disc list-inside text-red-800 dark:text-red-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950 border-2 border-emerald-300 dark:border-emerald-800 rounded-lg">
                <p class="text-emerald-900 dark:text-emerald-200">✓ {{ session('status') }}</p>
            </div>
        @endif

        <form action="{{ route('members.update-profile') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Name & Email Row -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">👤 Full Name *</label>
                    <input type="text" id="name" name="name" required value="{{ old('name', Auth::user()->name) }}"
                        class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                        focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 
                        dark:bg-slate-700 dark:text-white transition">
                    @error('name')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">📧 Email *</label>
                    <input type="email" id="email" name="email" required value="{{ old('email', Auth::user()->email) }}"
                        class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                        focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 
                        dark:bg-slate-700 dark:text-white transition">
                    @error('email')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Student ID & Phone Row -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="student_id" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">🎓 Student ID *</label>
                    <input type="text" id="student_id" name="student_id" required value="{{ old('student_id', Auth::user()->student_id) }}"
                        class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                        focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 
                        dark:bg-slate-700 dark:text-white transition">
                    @error('student_id')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact_details" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">📱 Phone Number</label>
                    <input type="text" id="contact_details" name="contact_details" value="{{ old('contact_details', Auth::user()->contact_details) }}"
                        placeholder="+254712345678" class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                        focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 
                        dark:bg-slate-700 dark:text-white transition">
                    @error('contact_details')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t-2 border-slate-300 dark:border-slate-700 pt-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">🔒 Change Password</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Leave blank to keep your current password</p>
            </div>

            <!-- Password Fields -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="current_password" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Current Password</label>
                    <input type="password" id="current_password" name="current_password"
                        class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                        focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 
                        dark:bg-slate-700 dark:text-white transition" placeholder="Enter current password to confirm">
                    @error('current_password')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">New Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                        focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 
                        dark:bg-slate-700 dark:text-white transition" placeholder="Leave blank to keep current">
                    @error('password')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                    focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 
                    dark:bg-slate-700 dark:text-white transition" placeholder="Confirm new password">
                @error('password_confirmation')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-slate-200 dark:border-slate-700">
                <button type="submit" class="flex-1 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg transition transform hover:scale-105">
                    ✓ Save Changes
                </button>
                <a href="{{ route('members.show', Auth::user()) }}" class="flex-1 px-6 py-3 bg-slate-300 hover:bg-slate-400 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-900 dark:text-white font-bold rounded-lg transition text-center">
                    ✕ Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
