<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index($gallery)
    {
        $galleries = Field::findOrFail($gallery);
        return view('gallery.index', compact('galleries'));
    }
}
