<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Gallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
            'date' => ['required', 'date']
        ]);

        DB::beginTransaction();
        try {
    
            $media = Gallery::create([
                'user_id' => auth()->user()->id,
                'field_id' => $gallery,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'category' => 'photo',
                'description' => $request->description,
                'activity' => Carbon::parse($request->date),
            ]);

            if ($request->medias != null) {
                if(!File::isDirectory('photo/'.$media->slug)){
                    File::makeDirectory('photo/'.$media->slug, 0777, true, true);
                }
            
                foreach ($request->medias as $file) {
                    $old = 'tmp/uploads/'.$file;
                    $new = 'photo/'.$media->slug.'/'.$file;
                    File::move($old, $new);
                    $media->files()->create([
                        'name' => $file,
                        'folder' => $media->slug
                    ]);
                }
            }
            DB::commit();

            return redirect()->route('photo.index', $gallery)->withSuccess('Berhasil menambah arsip foto');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('photo.index', $gallery)->with('error',$e->getMessage());
        }

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
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required'],
            'date' => ['required', 'date']
        ]);
        
        DB::beginTransaction();
        try {
            $media = Gallery::findOrFail($photo);

            $media->update([
                'name' => $request->name,
                'description' => $request->description,
                'activity' => Carbon::parse($request->date),
            ]);

            if ($request->medias != null) {
                foreach ($request->medias as $file) {
                    $old = 'tmp/uploads/'.$file;
                    $new = 'photo/'.$media->slug.'/'.$file;
                    File::move($old, $new);
                    $media->files()->create([
                        'name' => $file,
                        'folder' => $media->slug
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('photo.index', $gallery)->withSuccess('Berhasil update arsip foto');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('photo.index', $gallery)->with('error', $e->getMessage());
        }
    }

    public function destroy($gallery, $photo)
    {
        try {
            $photo = Gallery::findOrFail($photo);
            File::deleteDirectory('photo/'.$photo->files[0]->folder);
            File::delete($photo->name.'.zip');
            $photo->delete();

            return redirect()->route('photo.index', $gallery)->withSuccess('Berhasil hapus arsip foto');
        } catch (\Exception $e) {
            return redirect()->route('photo.index', $gallery)->with('error', $e->getMessage());
        }
    }

    public function download($gallery, $photo)
    {
        try {
            $photo = Gallery::findOrFail($photo);
            $zip_file = $photo->name.'.zip';

            $zip = new \ZipArchive();
            $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $path = public_path('photo/'.$photo->files[0]->folder);
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

            foreach ($files as $file)
            {
                // We're skipping all subfolders
                if (!$file->isDir()) {
                    $filePath     = $file->getRealPath();

                    // extracting filename with substr/strlen
                    $relativePath = substr($filePath, strlen($path) + 1);

                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
            return response()->download($zip_file);
        } catch (\Exception $e) {
            return redirect()->route('photo.index', $gallery)->with('error', $e->getMessage());
        }
    }
}
