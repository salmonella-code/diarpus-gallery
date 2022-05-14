<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Gallery;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    function finder($slug)
    {
        $result =  Field::where('slug',$slug)->firstOrFail();
        return $result;
    }

    public function index($gallery)
    {
        $galleries = $this->finder($gallery);
 
        return view('video.index', compact('galleries'));
    }

    public function create($gallery)
    {
        $galleries =  $this->finder($gallery);

        return view('video.create', compact('galleries'));
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
                'field_id' => $this->finder($gallery)->id,
                'name' => $request->name,
                'slug' => SlugService::createSlug(Gallery::class, 'slug', $request->name),
                'category' => 'video',
                'description' => $request->description,
                'activity' => Carbon::parse($request->date),
            ]);

            if ($request->medias != null) {
                if(!File::isDirectory('video/'.$media->slug)){
                    File::makeDirectory('video/'.$media->slug, 0777, true, true);
                }
            
                foreach ($request->medias as $file) {
                    $old = 'tmp/uploads/'.$file;
                    $new = 'video/'.$media->slug.'/'.$file;
                    File::move($old, $new);
                    $media->files()->create([
                        'name' => $file,
                        'folder' => $media->slug
                    ]);
                }
            }
            DB::commit();

            return redirect()->route('video.index', $gallery)->withSuccess('Berhasil menambah arsip video');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('video.index', $gallery)->with('error',$e->getMessage());
        }

    }

    public function show($gallery, $video)
    {
        $video = Gallery::findOrFail($video);

        return view('video.show', compact('gallery', 'video'));
    }

    public function edit($gallery, $video)
    {
        $video = Gallery::findOrFail($video);

        return view('video.edit', compact('gallery', 'video'));
    }

    public function update(Request $request,$gallery, $video)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required'],
            'date' => ['required', 'date']
        ]);
        
        DB::beginTransaction();
        try {
            $media = Gallery::findOrFail($video);

            $media->update([
                'name' => $request->name,
                'description' => $request->description,
                'activity' => Carbon::parse($request->date),
            ]);

            if ($request->medias != null) {
                foreach ($request->medias as $file) {
                    $old = 'tmp/uploads/'.$file;
                    $new = 'video/'.$media->slug.'/'.$file;
                    File::move($old, $new);
                    $media->files()->create([
                        'name' => $file,
                        'folder' => $media->slug
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('video.index', $gallery)->withSuccess('Berhasil update arsip video');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('video.index', $gallery)->with('error', $e->getMessage());
        }
    }

    public function destroy($gallery, $video)
    {
        try {
            $video = Gallery::findOrFail($video);
            File::deleteDirectory('video/'.$video->files[0]->folder);
            File::delete($video->name.'.zip');
            $video->delete();

            return redirect()->route('video.index', $gallery)->withSuccess('Berhasil hapus arsip video');
        } catch (\Exception $e) {
            return redirect()->route('video.index', $gallery)->with('error', $e->getMessage());
        }
    }

    public function download($gallery, $video)
    {
        try {
            $video = Gallery::findOrFail($video);
            $zip_file = $video->name.'.zip';

            $zip = new \ZipArchive();
            $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $path = public_path('video/'.$video->files[0]->folder);
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
            return redirect()->route('video.index', $gallery)->with('error', $e->getMessage());
        }
    }
}
