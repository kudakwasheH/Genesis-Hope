<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // Public List
    public function index(Request $request)
    {
        $query = Blog::with('author')->where('is_published', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->orderBy('published_at', 'desc')->paginate(6);
        return view('public.blog.index', compact('blogs'));
    }

    // Public Detail
    public function show(string $slug)
    {
        $blog = Blog::with('author')->where('slug', $slug)->firstOrFail();
        
        // Fetch 3 other related posts
        $relatedBlogs = Blog::where('slug', '!=', $slug)
            ->where('is_published', true)
            ->limit(3)
            ->get();

        return view('public.blog.show', compact('blog', 'relatedBlogs'));
    }

    // Admin Dashboard List
    public function adminIndex()
    {
        $blogs = Blog::with('author')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    // Admin Create Form
    public function create()
    {
        return view('admin.blogs.create');
    }

    // Admin Store
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // Max 2MB
            'is_published' => 'boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Store directly in public folder or storage
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'content' => $request->content,
            'image_path' => $imagePath,
            'author_id' => Auth::id(),
            'is_published' => $request->has('is_published') ? $request->is_published : false,
            'published_at' => $request->has('is_published') ? now() : null,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog article created successfully.');
    }

    // Admin Edit Form
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    // Admin Update
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);

        $imagePath = $blog->image_path;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        $wasPublished = $blog->is_published;
        $isPublished = $request->has('is_published') ? $request->is_published : false;
        
        $publishedAt = $blog->published_at;
        if ($isPublished && !$wasPublished) {
            $publishedAt = now();
        } elseif (!$isPublished) {
            $publishedAt = null;
        }

        $blog->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'content' => $request->content,
            'image_path' => $imagePath,
            'is_published' => $isPublished,
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog article updated successfully.');
    }

    // Admin Delete
    public function destroy(Blog $blog)
    {
        if ($blog->image_path) {
            Storage::disk('public')->delete($blog->image_path);
        }
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog article deleted successfully.');
    }
}
