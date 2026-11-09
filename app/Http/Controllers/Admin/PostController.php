<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'summary' => 'nullable|string|max:500',
            'body' => 'required|string',
            'is_published' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $imagePath = 'img/project-1.jpg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('posts', $fileName, 'public');
            $imagePath = 'storage/posts/' . $fileName;
        }

        $isPublished = ($request->input('is_published', 'PUBLISHED') === 'PUBLISHED');

        NewsPost::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . rand(100, 999),
            'category' => $validated['category'],
            'summary' => $validated['summary'] ?? Str::limit(strip_tags($validated['body']), 150),
            'body' => $validated['body'],
            'featured_image' => $imagePath,
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
        ]);

        return redirect()->route('admin.posts')->with('success', 'News announcement post published successfully!');
    }

    public function edit($id)
    {
        $post = NewsPost::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = NewsPost::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'summary' => 'nullable|string|max:500',
            'body' => 'required|string',
            'is_published' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('posts', $fileName, 'public');
            $post->featured_image = 'storage/posts/' . $fileName;
        }

        $isPublished = ($request->input('is_published', 'PUBLISHED') === 'PUBLISHED');

        $post->title = $validated['title'];
        $post->category = $validated['category'];
        $post->summary = $validated['summary'] ?? Str::limit(strip_tags($validated['body']), 150);
        $post->body = $validated['body'];
        $post->is_published = $isPublished;
        if ($isPublished && !$post->published_at) {
            $post->published_at = now();
        }
        $post->save();

        return redirect()->route('admin.posts')->with('success', 'News announcement updated successfully!');
    }

    public function destroy($id)
    {
        $post = NewsPost::findOrFail($id);
        
        if ($post->featured_image && str_contains($post->featured_image, 'storage/posts/')) {
            $storagePath = str_replace('storage/', 'public/', $post->featured_image);
            Storage::delete($storagePath);
        }

        $post->delete();

        return redirect()->back()->with('success', 'News post removed successfully!');
    }
}
