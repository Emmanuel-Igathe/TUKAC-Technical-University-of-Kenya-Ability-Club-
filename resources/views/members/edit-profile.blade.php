@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Back Button --}}
    <a href="{{ route('members.show', Auth::user()) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline mb-6 inline-flex items-center">
        ← Back to Profile
    </a>

    {{-- Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Profile</h1>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg">
                <h3 class="font-semibold text-red-800 dark:text-red-200 mb-2">Validation Errors:</h3>
                <ul class="list-disc list-inside text-red-700 dark:text-red-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Display success message --}}
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                <p class="text-green-800 dark:text-green-200">✓ {{ session('status') }}</p>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('members.update-profile') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Full Name <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', Auth::user()->name) }}"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Email Address <span class="text-red-600">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', Auth::user()->email) }}"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            {{-- Student ID --}}
            <div>
                <label for="student_id" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Student ID <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       id="student_id" 
                       name="student_id" 
                       value="{{ old('student_id', Auth::user()->student_id) }}"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            {{-- Contact Details --}}
            <div>
                <label for="contact_details" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Phone Number
                </label>
                <input type="text" 
                       id="contact_details" 
                       name="contact_details" 
                       value="{{ old('contact_details', Auth::user()->contact_details) }}"
                       placeholder="e.g., +254712345678"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Current Password --}}
            <div>
                <label for="current_password" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Current Password (to confirm changes)
                </label>
                <input type="password" 
                       id="current_password" 
                       name="current_password"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- New Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    New Password (leave blank to keep current)
                </label>
                <input type="password" 
                       id="password" 
                       name="password"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Confirm New Password
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Form Actions --}}
            <div class="flex gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                    Save Changes
                </button>
                <a href="{{ route('members.show', Auth::user()) }}" class="px-6 py-3 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white rounded-lg hover:bg-gray-400 dark:hover:bg-gray-700 transition font-semibold">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
