@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Back Button --}}
    <a href="{{ route('blog.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline mb-6 inline-flex items-center">
        ← Back to Blog
    </a>

    {{-- Post Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-8">
        @if ($post->featured_image_path)
            <img src="{{ asset('storage/' . $post->featured_image_path) }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-96 object-cover">
        @else
            <div class="w-full h-96 bg-gradient-to-br from-blue-300 to-indigo-300 dark:from-blue-900 dark:to-indigo-900 flex items-center justify-center">
                <span class="text-9xl">📰</span>
            </div>
        @endif
        
        <div class="p-8">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 uppercase">
                        {{ ucfirst($post->category) }}
                    </span>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mt-2 mb-2">
                        {{ $post->title }}
                    </h1>
                    <div class="flex items-center gap-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-indigo-200 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                                ✍️
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $post->author->name ?? 'Admin' }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $post->created_at->format('M d, Y \a\t H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            📝 {{ str_word_count($post->content) }} words
                        </div>
                    </div>
                </div>

                @if (Auth::user()->id === $post->author_id || Auth::user()->isAdmin())
                    <div class="flex gap-2">
                        <a href="{{ route('blog.edit', $post) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Edit
                        </a>
                        <form action="{{ route('blog.destroy', $post) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Post Content --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-8 prose dark:prose-invert max-w-none">
        <div class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap text-lg">
            {{ $post->content }}
        </div>
    </div>

    {{-- Comments Section --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">
            Comments ({{ $post->comments->count() }})
        </h2>

        {{-- Add Comment Form --}}
        @auth
            <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Add a Comment</h3>
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="blog_post_id" value="{{ $post->id }}">
                    
                    <textarea name="content" 
                              rows="4"
                              placeholder="Share your thoughts..."
                              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 mb-4"
                              required></textarea>
                    
                    @if ($errors->has('content'))
                        <p class="text-red-600 dark:text-red-400 text-sm mb-4">
                            {{ $errors->first('content') }}
                        </p>
                    @endif
                    
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                        Post Comment
                    </button>
                </form>
            </div>
        @else
            <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Login</a> 
                    to leave a comment
                </p>
            </div>
        @endauth

        {{-- Comments List --}}
        @forelse ($post->comments as $comment)
            <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700 last:border-0">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-200 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                            👤
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                {{ $comment->user->name }}
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $comment->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    @if (Auth::check() && (Auth::user()->id === $comment->user_id || Auth::user()->isAdmin()))
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline text-sm" onclick="return confirm('Delete this comment?')">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>

                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    {{ $comment->content }}
                </p>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-gray-500 dark:text-gray-400">
                    No comments yet. Be the first to comment!
                </p>
            </div>
        @endforelse
    </div>

    {{-- Related Posts --}}
    @php
        $relatedPosts = \App\Models\BlogPost::where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->recent()
            ->take(3)
            ->get();
    @endphp

    @if ($relatedPosts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Related Posts</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($relatedPosts as $related)
                    <a href="{{ route('blog.show', $related) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <div class="h-40 bg-gradient-to-br from-blue-200 to-indigo-200 dark:from-blue-900 dark:to-indigo-900 flex items-center justify-center">
                            @if ($related->featured_image_path)
                                <img src="{{ asset('storage/' . $related->featured_image_path) }}" 
                                     alt="{{ $related->title }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl">📰</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase">
                                {{ ucfirst($related->category) }}
                            </span>
                            <h3 class="font-semibold text-gray-900 dark:text-white mt-1 line-clamp-2">
                                {{ $related->title }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                {{ $related->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
