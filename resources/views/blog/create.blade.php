@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Back Button --}}
    <a href="{{ route('blog.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline mb-6 inline-flex items-center">
        ← Back to Blog
    </a>

    {{-- Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
            {{ isset($post) ? 'Edit Post' : 'Write Post' }}
        </h1>

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

        {{-- Form --}}
        <form action="{{ isset($post) ? route('blog.update', $post) : route('blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if (isset($post))
                @method('PUT')
            @endif

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Post Title <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $post->title ?? '') }}"
                       placeholder="Write a compelling title..."
                       class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            {{-- Category --}}
            <div>
                <label for="category" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Category <span class="text-red-600">*</span>
                </label>
                <select id="category" 
                        name="category" 
                        class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                    <option value="announcements" {{ old('category', $post->category ?? '') === 'announcements' ? 'selected' : '' }}>📢 Announcements</option>
                    <option value="stories" {{ old('category', $post->category ?? '') === 'stories' ? 'selected' : '' }}>✨ Member Stories</option>
                    <option value="updates" {{ old('category', $post->category ?? '') === 'updates' ? 'selected' : '' }}>🔔 Updates</option>
                </select>
            </div>

            {{-- Featured Image --}}
            <div>
                <label for="featured_image" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Featured Image
                </label>
                <input type="file" 
                       id="featured_image" 
                       name="featured_image_path"
                       accept="image/*"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    Recommended: 16:9 aspect ratio, at least 800x450px
                </p>
                @if (isset($post) && $post->featured_image_path)
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                        Current image: <a href="{{ asset('storage/' . $post->featured_image_path) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">View</a>
                    </p>
                @endif
            </div>

            {{-- Content --}}
            <div>
                <label for="content" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Content <span class="text-red-600">*</span>
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="12"
                          placeholder="Write your post content here..."
                          class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 font-mono"
                          required>{{ old('content', $post->content ?? '') }}</textarea>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    💡 Tip: Use line breaks for better readability
                </p>
            </div>

            {{-- Form Actions --}}
            <div class="flex gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                    {{ isset($post) ? 'Update Post' : 'Publish Post' }}
                </button>
                <a href="{{ route('blog.index') }}" class="px-6 py-3 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white rounded-lg hover:bg-gray-400 dark:hover:bg-gray-700 transition font-semibold">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
