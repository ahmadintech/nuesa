<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StudentAlbum;

class AlbumController extends Controller
{
    public function __invoke()
    {
        $albums = StudentAlbum::with('department')->latest()->get();

        return view('album', compact('albums'));
    }
}
