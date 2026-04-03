@extends('layouts.guest')

@section('title', 'Forgot Password - TUK Ability Club')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-600 mb-2">
                <i class="fas fa-wheelchair mr-2"></i>TUK Ability Club
            </h1>
            <h2 class="text-xl font-semibold text-gray-800">Forgot Password?</h2>
            <p class="text-gray-600 text-sm mt-2">No worries, we'll help you reset it.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800 text-sm">{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required 
                    autofocus
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                    placeholder="you@example.com"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
            >
                Send Password Reset Link
            </button>

            <!-- Back to Login -->
            <div class="text-center border-t border-gray-200 pt-4 mt-4">
                <p class="text-gray-600 text-sm">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">Back to Login</a>
                </p>
            </div>
        </form>

        <!-- Help Text -->
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                Enter your email address and we'll send you a link to reset your password within a few minutes.
            </p>
        </div>
    </div>
</div>
@endsection
