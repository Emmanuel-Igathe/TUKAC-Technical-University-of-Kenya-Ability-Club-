<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogPostController extends Controller
{
    /**
     * Display all blog posts
     */
    public function index(Request $request)
    {
        $query = BlogPost::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(10);
        return view('blog.index', ['posts' => $posts]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $this->authorize('isExecutive');
        return view('blog.create');
    }

    /**
     * Store new post
     */
    public function store(Request $request)
    {
        $this->authorize('isExecutive');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:announcements,stories,updates',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $post = BlogPost::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'author_id' => Auth::id(),
        ]);

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blog', 'public');
            $post->update(['featured_image_path' => $path]);
        }

        return redirect('/blog')->with('status', 'Blog post created!');
    }

    /**
     * Show post details
     */
    public function show(BlogPost $post)
    {
        $comments = $post->comments()->with('user')->get();
        return view('blog.show', ['post' => $post, 'comments' => $comments]);
    }

    /**
     * Show edit form
     */
    public function edit(BlogPost $post)
    {
        $this->authorize('authorOwner', $post);
        return view('blog.edit', ['post' => $post]);
    }

    /**
     * Update post
     */
    public function update(Request $request, BlogPost $post)
    {
        $this->authorize('authorOwner', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:announcements,stories,updates',
        ]);

        $post->update($validated);
        return redirect("/blog/{$post->id}")->with('status', 'Post updated!');
    }

    /**
     * Delete post
     */
    public function destroy(BlogPost $post)
    {
        $this->authorize('authorOwner', $post);
        $post->delete();
        return redirect('/blog')->with('status', 'Post deleted!');
    }
}
