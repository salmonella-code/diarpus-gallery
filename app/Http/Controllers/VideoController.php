<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Gallery;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use File;

class VideoController extends Controller
{
    public function index($gallery)
    {
        $galleries =  Field::findOrFail($gallery);

        return view('video.index', compact('galleries'));
    }

    public function create($gallery)
    {
        $galleries =  Field::findOrFail($gallery);

        return view('video.create', compact('galleries'));
    }

    public function store(Request $request, $gallery)
    {
        $request->validate([
            'description' => ['required'],
        ]);

        $temporaryFile = TemporaryFile::where('folder', $request->path)->first();

        $item = new Gallery();
        $item->user_id = auth()->user()->id;
        $item->field_id = $gallery;
        $item->category = 'video';
        $item->description = $request->description;
        if ($temporaryFile) {
            $old = 'video/tmp/'.$temporaryFile->folder.'/'.$temporaryFile->filename;
            $new = 'video/'.$temporaryFile->filename;
            File::move($old, $new);
            $item->url_gallery = $temporaryFile->filename;
            rmdir('video/tmp/' . $temporaryFile->folder);
            $temporaryFile->delete();
        }else{
            $item->url_gallery = null;
        }
        $item->save();

        return redirect()->route('video.index', $gallery)->withSuccess('Berhasil menambah video');
    }
}
