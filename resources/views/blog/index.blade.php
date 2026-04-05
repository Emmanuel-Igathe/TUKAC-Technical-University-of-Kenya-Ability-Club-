@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Header with Create Button --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Club Blog</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Read announcements, updates, and member stories</p>
        </div>
        @if (Auth::user()->isExecutive() || Auth::user()->isAdmin())
            <a href="{{ route('blog.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                + Write Post
            </a>
        @endif
    </div>

    {{-- Filter by Category --}}
    <div class="mb-8">
        <div class="flex gap-3 flex-wrap">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                ✓ All Posts
            </button>
            <button class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                📢 Announcements
            </button>
            <button class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                ✨ Member Stories
            </button>
            <button class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                🔔 Updates
            </button>
        </div>
    </div>

    {{-- Blog Posts Grid --}}
    <div class="grid lg:grid-cols-3 gap-8 mb-12">
        {{-- Featured Post (if available) --}}
        @php
            $featuredPost = \App\Models\BlogPost::recent()->first();
        @endphp
        @if ($featuredPost)
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden hover:shadow-2xl transition">
                <div class="h-64 bg-gradient-to-br from-indigo-300 to-blue-300 dark:from-indigo-900 dark:to-blue-900 flex items-center justify-center">
                    @if ($featuredPost->featured_image_path)
                        <img src="{{ asset('storage/' . $featuredPost->featured_image_path) }}" 
                             alt="{{ $featuredPost->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-8xl">📰</span>
                    @endif
                </div>
                <div class="p-8">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 uppercase">
                            📌 Featured • {{ ucfirst($featuredPost->category) }}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $featuredPost->created_at->format('M d, Y') }}
                        </span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $featuredPost->title }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mb-6 line-clamp-3">
                        {{ $featuredPost->getExcerpt() }}
                    </p>
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-200 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                                ✍️
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white text-sm">
                                    {{ $featuredPost->author->name ?? 'Admin' }}
                                </p>
                                <p class="text-gray-500 dark:text-gray-400 text-xs">
                                    {{ $featuredPost->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('blog.show', $featuredPost) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">
                            Read →
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Recent Posts Sidebar --}}
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Posts</h3>
            @forelse (\App\Models\BlogPost::recent()->skip(1)->take(5)->get() as $post)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase">
                            {{ ucfirst($post->category) }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $post->created_at->format('M d') }}
                        </span>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 hover:text-indigo-600 dark:hover:text-indigo-400">
                        <a href="{{ route('blog.show', $post) }}">
                            {{ $post->title }}
                        </a>
                    </h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        ✍️ {{ $post->author->name ?? 'Admin' }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm">No posts yet</p>
            @endforelse
        </div>
    </div>

    {{-- All Blog Posts Grid --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">All Posts</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse (\App\Models\BlogPost::recent()->get() as $post)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-blue-200 to-indigo-200 dark:from-blue-900 dark:to-indigo-900 flex items-center justify-center">
                        @if ($post->featured_image_path)
                            <img src="{{ asset('storage/' . $post->featured_image_path) }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-6xl">📰</span>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase">
                                {{ ucfirst($post->category) }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $post->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
                            {{ $post->title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                            {{ $post->getExcerpt() }}
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                ✍️ {{ $post->author->name ?? 'Admin' }}
                            </span>
                            <a href="{{ route('blog.show', $post) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold text-sm">
                                Read →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        No blog posts yet. Check back soon!
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
