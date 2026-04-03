@extends('layouts.app')

@section('title', 'Edit Blog Post - TUK Ability Club')
@section('header', 'Edit Blog Post')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('blog.show', $blogPost) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>Back to Post
            </a>
        </div>

        <!-- Form Header -->
        <div class="mb-8 border-b border-gray-200 pb-6">
            <h2 class="text-3xl font-bold text-gray-800">Edit Blog Post</h2>
            <p class="text-gray-600 mt-2">Update the content of your blog post</p>
        </div>

        <!-- Errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <h3 class="text-red-800 font-semibold mb-2">Please fix the following errors:</h3>
                <ul class="list-disc list-inside text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Form -->
        <form method="POST" action="{{ route('blog.update', $blogPost) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Post Title</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $blogPost->title) }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                    placeholder="Enter post title"
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select 
                    id="category" 
                    name="category" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror"
                >
                    <option value="">Select a category</option>
                    <option value="announcements" {{ old('category', $blogPost->category) === 'announcements' ? 'selected' : '' }}>Announcements</option>
                    <option value="stories" {{ old('category', $blogPost->category) === 'stories' ? 'selected' : '' }}>Stories</option>
                    <option value="updates" {{ old('category', $blogPost->category) === 'updates' ? 'selected' : '' }}>Updates</option>
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="12"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono @error('content') border-red-500 @enderror"
                    placeholder="Write your blog post content here..."
                >{{ old('content', $blogPost->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image URL (if applicable) -->
            <div>
                <label for="featured_image_path" class="block text-sm font-medium text-gray-700 mb-1">Featured Image URL</label>
                <input 
                    type="url" 
                    id="featured_image_path" 
                    name="featured_image_path" 
                    value="{{ old('featured_image_path', $blogPost->featured_image_path) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('featured_image_path') border-red-500 @enderror"
                    placeholder="https://example.com/image.jpg"
                >
                @error('featured_image_path')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4 pt-6 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200"
                >
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
                <a 
                    href="{{ route('blog.show', $blogPost) }}" 
                    class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition duration-200"
                >
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                @can('delete', $blogPost)
                <form method="POST" action="{{ route('blog.destroy', $blogPost) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition duration-200"
                    >
                        <i class="fas fa-trash mr-2"></i>Delete Post
                    </button>
                </form>
                @endcan
            </div>
        </form>
    </div>
</div>
@endsection
