<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TUK Ability Club')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @yield('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold">🏛️ TUK Ability Club</a>
                </div>

                <!-- Menu -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Dashboard</a>
                        <a href="{{ route('events.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Events</a>
                        <a href="{{ route('blog.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Blog</a>
                        <a href="{{ route('finance.dashboard') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Finance</a>
                        <a href="{{ route('members.directory') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Members</a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="bg-red-600 hover:bg-red-700 px-3 py-2 rounded">Admin</a>
                        @endif

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center hover:bg-blue-700 px-3 py-2 rounded">
                                {{ auth()->user()->name }} ▼
                            </button>
                            <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded shadow-lg">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Login</a>
                        <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 px-3 py-2 rounded">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('status'))
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <!-- Errors -->
    @if($errors->any())
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>Errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2026 TUK Ability Club. All rights reserved.</p>
            <p class="text-sm text-gray-400 mt-2">Committed to disability inclusion and accessibility</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
