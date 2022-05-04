<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

class PhotoController extends Controller
{
    public function index($gallery)
    {
        $galleries = Field::findOrFail($gallery);

        return view('photo.index', compact('galleries'));
    }

    public function create($gallery)
    {
        $galleries = Field::findOrFail($gallery);
        return view('photo.create', compact('galleries'));
    }

    public function store(Request $request, $gallery)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required'],
        ]);

        $media = Gallery::create([
            'user_id' => auth()->user()->id,
            'field_id' => $gallery,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category' => 'photo',
            'description' => $request->description,
        ]);

        foreach ($request->medias as $file) {
            $media->addMedia('tmp/uploads/' . $file)->toMediaCollection('photo');
        }

        return redirect()->route('photo.index', $gallery)->withSuccess('Berhasil menambah foto');
    }

    public function show($gallery, $photo)
    {
        $photo = Gallery::findOrFail($photo);

        return view('photo.show', compact('gallery', 'photo'));
    }

    public function edit($gallery, $photo)
    {
        $photo = Gallery::findOrFail($photo);

        return view('photo.edit', compact('gallery', 'photo'));
    }

    public function update(Request $request,$gallery, $photo)
    {
        $photo = Gallery::findOrFail($photo);
        $request->validate([
            'description' => ['required'],
        ]);

        $temporaryFile = TemporaryFile::where('folder', $request->path)->first();
        if (is_null($temporaryFile)) {
            $photo->update([
                'description' => $request->description,
            ]);
        }elseif (!is_null($temporaryFile)) {
            File::delete('photo/'.$photo->url_gallery);
            $old = 'photo/tmp/'.$temporaryFile->folder.'/'.$temporaryFile->filename;
            $new = 'photo/'.$temporaryFile->filename;
            File::move($old, $new);
            $photo->update([
                'description' => $request->description,
                'url_gallery' => $temporaryFile->filename
            ]);
            rmdir('photo/tmp/' . $temporaryFile->folder);
            $temporaryFile->delete();
        }

        return redirect()->route('photo.index', $gallery)->withSuccess('Berhasil edit foto');
    }

    public function destroy($gallery, $photo)
    {
        $photo = Gallery::findOrFail($photo);
        File::delete('photo/'.$photo->url_gallery);
        $photo->delete();
        return redirect()->route('photo.index', $gallery)->withSuccess('Berhasil hapus foto');
    }
}
