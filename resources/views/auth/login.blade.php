@extends('layouts.guest')

@section('title', 'Login - TUK Ability Club')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-8 text-center">
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                    <span class="text-3xl">🎓</span>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">TUK Ability Club</h1>
                <p class="text-indigo-100">Welcome back</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Errors -->
                @if($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <span class="text-xl flex-shrink-0">⚠️</span>
                            <div class="flex-1">
                                @foreach($errors->all() as $error)
                                    <p class="text-red-700 dark:text-red-200 text-sm">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf

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
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg focus:border-indigo-500 dark:focus:border-indigo-400 focus:bg-white dark:focus:bg-slate-600 focus:ring-2 focus:ring-indigo-500/20 transition outline-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                            placeholder="your@email.com"
                        >
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
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg focus:border-indigo-500 dark:focus:border-indigo-400 focus:bg-white dark:focus:bg-slate-600 focus:ring-2 focus:ring-indigo-500/20 transition outline-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                            placeholder="••••••••"
                        >
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-slate-300 text-indigo-600">
                        <label for="remember" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition shadow-lg hover:shadow-xl active:scale-95"
                    >
                        ➔ Sign In
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

                <!-- Register Link -->
                <p class="text-center text-gray-600 dark:text-gray-400">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition">
                        Create one →
                    </a>
                </p>

                <!-- Forgot Password Link -->
                <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4">
                    <a href="{{ route('password.request') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition">
                        Forgot your password?
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
