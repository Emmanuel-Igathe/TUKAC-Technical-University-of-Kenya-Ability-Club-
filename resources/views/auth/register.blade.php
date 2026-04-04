@extends('layouts.guest')

@section('title', 'Register - TUK Ability Club')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-lg">
        <!-- Card Container -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-8 text-center">
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                    <span class="text-3xl">🎓</span>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">TUK Ability Club</h1>
                <p class="text-emerald-100">Join our community today</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Full Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            👤 Full Name
                        </label>
                        <input 
                            type="text" 
                            id="name"
                            name="name" 
                            value="{{ old('name') }}" 
                            required
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg focus:border-emerald-500 dark:focus:border-emerald-400 focus:bg-white dark:focus:bg-slate-600 focus:ring-2 focus:ring-emerald-500/20 transition outline-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                            placeholder="John Doe"
                        >
                        @error('name')<p class="text-red-600 dark:text-red-400 text-xs mt-1">⚠️ {{ $message }}</p>@enderror
                    </div>

                    <!-- Student ID Field -->
                    <div>
                        <label for="student_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            🆔 Student ID
                        </label>
                        <input 
                            type="text" 
                            id="student_id"
                            name="student_id" 
                            value="{{ old('student_id') }}" 
                            required
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg focus:border-emerald-500 dark:focus:border-emerald-400 focus:bg-white dark:focus:bg-slate-600 focus:ring-2 focus:ring-emerald-500/20 transition outline-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                            placeholder="TUK/000000"
                        >
                        @error('student_id')<p class="text-red-600 dark:text-red-400 text-xs mt-1">⚠️ {{ $message }}</p>@enderror
                    </div>

                    <!-- Email Field -->
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
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg focus:border-emerald-500 dark:focus:border-emerald-400 focus:bg-white dark:focus:bg-slate-600 focus:ring-2 focus:ring-emerald-500/20 transition outline-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                            placeholder="your@email.com"
                        >
                        @error('email')<p class="text-red-600 dark:text-red-400 text-xs mt-1">⚠️ {{ $message }}</p>@enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            🔐 Password
                        </label>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            required
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg focus:border-emerald-500 dark:focus:border-emerald-400 focus:bg-white dark:focus:bg-slate-600 focus:ring-2 focus:ring-emerald-500/20 transition outline-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                            placeholder="••••••••"
                        >
                        @error('password')<p class="text-red-600 dark:text-red-400 text-xs mt-1">⚠️ {{ $message }}</p>@enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            🔐 Confirm Password
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation"
                            name="password_confirmation" 
                            required
                            class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg focus:border-emerald-500 dark:focus:border-emerald-400 focus:bg-white dark:focus:bg-slate-600 focus:ring-2 focus:ring-emerald-500/20 transition outline-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                            placeholder="••••••••"
                        >
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold py-3 px-4 rounded-lg transition shadow-lg hover:shadow-xl active:scale-95 mt-6"
                    >
                        ✓ Create Account
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

                <!-- Login Link -->
                <p class="text-center text-gray-600 dark:text-gray-400">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition">
                        Sign in →
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

            <p class="text-center mt-4 text-gray-600">
                Already have an account? <a href="{{ route('login') }}" class="text-blue-600 font-bold">Login here</a>
            </p>
        </form>
    </div>
</div>
@endsection
