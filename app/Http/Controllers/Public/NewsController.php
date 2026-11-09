<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;

class NewsController extends Controller
{
    public function index()
    {
        $posts = NewsPost::where('is_published', true)->latest('published_at')->paginate(6);

        return view('news', compact('posts'));
    }

    public function show($slug)
    {
        $post = NewsPost::where('slug', $slug)->firstOrFail();
        
        $relatedPosts = NewsPost::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(2)
            ->get();

        $recentPosts = NewsPost::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news_show', compact('post', 'relatedPosts', 'recentPosts'));
    }
}
