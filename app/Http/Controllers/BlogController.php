<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::paginate(10);
        return view('blogs.show', compact('blogs'));
    }

    public function edit($blogID)
    {
        $blog = Blog::findOrFail($blogID);
        // Fallback if cover image doesn't exist
        // $coverImagePath = 'blogs/' . $blog->cover_image;
        // if (!Storage::disk('public')->exists($coverImagePath)) {
        //     $blog->cover_image = 'public\images\istockphoto-1147544807-612x612.jpg'; // This should exist in storage/app/public/blogs
        // }
        return view('blogs.editBlog', compact('blog'));
    }

    public function update(Request $request, $blogID)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'tags' => 'nullable|string|max:255',
            'content' => 'required|string',
            'publish_date' => 'nullable|date',
            'status' => 'required|in:draft,archive,published',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $blog = Blog::findOrFail($blogID);

        $blog->title = $request->input('title');
        $blog->category = $request->input('category');
        $blog->tags = $request->input('tags');
        $blog->content = $request->input('content');
        $blog->publish_date = $request->input('publish_date');
        $blog->status = $request->input('status');
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('blogs', 'public');
            $blog->cover_image = $imagePath;
        }
        $blog->save();
        return redirect()->route('blog.index')->with('success', 'Blog updated successfully.');
    }


    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'action' => 'required|in:publish,archive',
            'blogs' => 'required|array',
            'blogs.*' => 'exists:blogs,blogID',
        ]);

        $action = $request->input('action');
        $blogs = Blog::whereIn('blogID', $request->input('blogs'));

        if ($action == 'publish') {
            $blogs->update(['status' => 'published']);
        } elseif ($action == 'archive') {
            $blogs->update(['status' => 'archive']);
        }

        return response()->json(['success' => true]);
    }

    public function add()
    {
        return view('blogs.addBlog');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:255',
            'publish_date' => 'nullable|date',
            'status' => 'required|in:draft,archive,published',
            'cover_image' => 'nullable|image|max:2048',
            'content' => 'required|string',
        ]);

        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('blogs', 'public');
            $validated['cover_image'] = $imagePath;
        }

        Blog::create($validated);

        return redirect()->route('blog.index')->with('success', 'Blog added successfully!');
    }
}
