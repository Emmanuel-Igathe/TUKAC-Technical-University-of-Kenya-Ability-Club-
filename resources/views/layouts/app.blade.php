<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TUK Ability Club')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @yield('styles')
</head>
<body class="bg-gradient-to-b from-slate-50 to-slate-100 dark:from-slate-950 dark:to-slate-900">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white dark:bg-slate-900 shadow-md border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-lg flex items-center justify-center transform group-hover:scale-105 transition">
                        <span class="text-xl">🎓</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white hidden sm:inline">TUK Ability Club</span>
                </a>

                <!-- Menu Hamburger for Mobile -->
                <div class="md:hidden" x-data="{ mobileOpen: false }">
                    <button @click="mobileOpen = !mobileOpen" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                        <span class="text-2xl">☰</span>
                    </button>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            Dashboard
                        </a>
                        <a href="{{ route('events.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            Events
                        </a>
                        <a href="{{ route('blog.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            Blog
                        </a>
                        <a href="{{ route('members.directory') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            Members
                        </a>
                        <a href="{{ route('finance.dashboard') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            Finance
                        </a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 bg-red-500/10 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-500/20 text-sm font-medium transition">
                                Admin Panel
                            </a>
                        @endif

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                                <span class="text-gray-400">▼</span>
                            </button>
                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-lg shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-slate-700">
                                    👤 My Profile
                                </a>
                                <hr class="border-slate-200 dark:border-slate-700">
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-600 dark:hover:text-red-400">
                                        🚪 Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium transition shadow-md hover:shadow-lg">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages with Modern Design -->
    @if(session('status'))
        <div class="fixed top-20 right-4 max-w-md z-40" x-data="{ show: true }" x-show="show">
            <div class="bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 rounded-lg shadow-lg p-4 flex items-start gap-4">
                <span class="text-2xl flex-shrink-0">✅</span>
                <div class="flex-1">
                    <p class="text-emerald-900 dark:text-emerald-100 font-medium">{{ session('status') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">✕</button>
            </div>
        </div>
    @endif

    <!-- Errors with Modern Design -->
    @if($errors->any())
        <div class="fixed top-20 right-4 max-w-md z-40" x-data="{ show: true }" x-show="show">
            <div class="bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 rounded-lg shadow-lg p-4">
                <div class="flex items-start gap-4">
                    <span class="text-2xl flex-shrink-0">⚠️</span>
                    <div class="flex-1">
                        <p class="font-semibold text-red-900 dark:text-red-100 mb-2">Errors:</p>
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="text-red-800 dark:text-red-200 text-sm">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" class="text-red-400 hover:text-red-600 flex-shrink-0">✕</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-[calc(100vh-64px-120px)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 dark:bg-black text-gray-300 border-t border-slate-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-lg flex items-center justify-center">
                            🎓
                        </div>
                        <span class="font-bold text-white">TUK Ability Club</span>
                    </div>
                    <p class="text-sm text-gray-400">Empowering students with disabilities at TUK</p>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('events.index') }}" class="hover:text-indigo-400 transition">Events</a></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-indigo-400 transition">Blog</a></li>
                        <li><a href="{{ route('members.directory') }}" class="hover:text-indigo-400 transition">Members</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Resources</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-indigo-400 transition">Support</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Follow Us</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition">f</a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition">𝕏</a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition">📷</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-400">&copy; 2026 TUK Ability Club. All rights reserved.</p>
                <p class="text-sm text-gray-400 mt-4 md:mt-0">Committed to disability inclusion and accessibility</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
