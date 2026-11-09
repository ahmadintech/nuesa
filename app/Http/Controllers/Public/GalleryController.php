<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;

class GalleryController extends Controller
{
    public function __invoke()
    {
        $items = GalleryItem::with('department')->latest()->get();

        return view('gallery', compact('items'));
    }
}
