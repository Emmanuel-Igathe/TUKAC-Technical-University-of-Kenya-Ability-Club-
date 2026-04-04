@extends('layouts.guest')

@section('title', 'Forgot Password - TUK Ability Club')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
            <!-- Header -->
            <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-6 py-8 text-center">
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                    <span class="text-3xl">🔐</span>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Reset Password</h1>
                <p class="text-amber-100">Don't worry, we'll help you get back in</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Success Message -->
                @if (session('status'))
                    <div class="mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <span class="text-xl flex-shrink-0">✓</span>
                            <p class="text-emerald-700 dark:text-emerald-200 text-sm">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                <p class="text-gray-600 dark:text-gray-300 text-sm mb-6">
                    Enter your email address and we'll send you a link to reset your password.
                </p>

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            📧 Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            autofocus
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg focus:border-amber-500 dark:focus:border-amber-400 focus:bg-white dark:focus:bg-slate-600 focus:ring-2 focus:ring-amber-500/20 transition outline-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('email') border-red-500 dark:border-red-500 @enderror"
                            placeholder="your@email.com"
                        >
                        @error('email')
                            <p class="mt-1 text-red-600 dark:text-red-400 text-xs">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-semibold py-3 px-4 rounded-lg transition shadow-lg hover:shadow-xl active:scale-95"
                    >
                        ➔ Send Reset Link
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white dark:bg-slate-800 text-gray-500 dark:text-gray-400">or</span>
                    </div>
                </div>

                <!-- Back to Login Link -->
                <p class="text-center text-gray-600 dark:text-gray-400">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition">
                        Back to login →
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer Info -->
        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-8">
            Empowering students with disabilities • TUK Ability Club
        </p>
    </div>
</div>
@endsection

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
