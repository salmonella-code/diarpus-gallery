<?php

namespace App\Http\Controllers\Village;

use App\Http\Controllers\Controller;
use App\Models\ActiveVillage;
use App\Models\Gallery;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VideoController extends Controller
{
    function finder($slug)
    {
        $result =  ActiveVillage::where('slug',$slug)->with('videos')->firstOrFail();
        return $result;
    }

    public function index($village)
    {
        $gallery = $this->finder($village);
        return view('villages.video.index', compact('gallery'));
    }

    public function create($gallery)
    {
        $galleries = $this->finder($gallery);
        return view('villages.video.create', compact('galleries'));
    }

    public function store(Request $request, $gallery)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required'],
            'date' => ['required', 'date']
        ]);

        $village = $this->finder($gallery);

        DB::beginTransaction();

        try {
            $media = Gallery::create([
                'user_id' => auth()->user()->id,
                'active_village_id' => $village->id,
                'name' => $request->name,
                'slug' => SlugService::createSlug(Gallery::class, 'slug', $request->name),
                'category' => 'video',
                'description' => $request->description,
                'activity' => Carbon::parse($request->date),
            ]);

            if ($request->medias != null) {
                if(!File::isDirectory('village/'.$village->slug.'/video/'.$media->slug)){
                    File::makeDirectory('village/'.$village->slug.'/video/'.$media->slug, 0777, true, true);
                }
            
                foreach ($request->medias as $file) {
                    $old = 'tmp/uploads/'.$file;
                    $new = 'village/'.$village->slug.'/video/'.$media->slug.'/'.$file;
                    File::move($old, $new);
                    $media->files()->create([
                        'name' => $file,
                        'folder' => $media->slug
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('village.video.index', $gallery)->withSuccess('Berhasil menambah arsip video: '.$media->name);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('village.video.index', $gallery)->with('error', 'Gagal menambah arsip video');
        }

    }

    public function show($gallery, $video)
    {
        $video = Gallery::with('village')->with('files')->findOrFail($video);

        return view('villages.video.show', compact('gallery', 'video'));
    }

    public function edit($gallery, $video)
    {
        $video = Gallery::with('village')->with('files')->findOrFail($video);

        return view('villages.video.edit', compact('gallery', 'video'));
    }

    public function update(Request $request, $gallery, $video)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required'],
            'date' => ['required', 'date']
        ]);
        
        DB::beginTransaction();
        try {
            $media = Gallery::findOrFail($video);
            $mediaOldName = $media->slug;

            $media->update([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => SlugService::createSlug(Gallery::class, 'slug', $request->name),
                'activity' => Carbon::parse($request->date),
            ]);

            if(isset($media->getChanges()['slug']) == true){
                rename('village/'.$gallery.'/video/'.$mediaOldName, 'village/'.$gallery.'/video/'.$media->slug);
                foreach ($media->files as $file) {
                    $file->update([
                        'folder' => $media->slug
                    ]);
                }
            }

            if ($request->medias != null) {
                foreach ($request->medias as $file) {
                    $old = 'tmp/uploads/'.$file;
                    $new = 'village/'.$gallery.'/video/'.$media->slug.'/'.$file;
                    File::move($old, $new);
                    $media->files()->create([
                        'name' => $file,
                        'folder' => $media->slug
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('village.video.index', $gallery)->withSuccess('Berhasil update arsip video: '.$media->name);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('village.video.index', $gallery)->with('error', 'Gagal update arsip video');
        }
    }

    public function destroy($gallery, $video)
    {
        try {
            $media = Gallery::findOrFail($video);
            File::deleteDirectory('village/'.$gallery.'/video/'.$media->slug);
            File::delete($media->name.'.zip');
            $media->delete();

            return redirect()->route('village.video.index', $gallery)->withSuccess('Berhasil hapus arsip video: '.$media->name);
        } catch (\Exception $e) {
            return redirect()->route('village.video.index', $gallery)->with('error', 'Gagal menghapus arsip video');
        }
    }

    public function download($gallery, $video)
    {
        try {
            $video = Gallery::findOrFail($video);
            $zip_file = $video->name.'.zip';

            $zip = new \ZipArchive();
            $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $path = public_path('village/'.$gallery.'/video/'.$video->files[0]->folder);
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
            return redirect()->route('village.video.index', $gallery)->with('error', 'Gagal mendownload arsip video');
        }
    }
}
