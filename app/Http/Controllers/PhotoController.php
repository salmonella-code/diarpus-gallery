<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Gallery;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PhotoController extends Controller
{
    function finder($slug)
    {
        $result =  Field::where('slug',$slug)->with('photos')->firstOrFail();
        return $result;
    }

    public function index($field)
    {
        $gallery = $this->finder($field);
        return view('photo.index', compact('gallery'));
    }

    public function create($gallery)
    {
        $galleries = $this->finder($gallery);
        return view('photo.create', compact('galleries'));
    }

    public function store(Request $request, $gallery)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required'],
            'date' => ['required', 'date']
        ]);

        $field = $this->finder($gallery);

        DB::beginTransaction();

        try {
            $media = Gallery::create([
                'user_id' => auth()->user()->id,
                'field_id' => $field->id,
                'name' => $request->name,
                'slug' => SlugService::createSlug(Gallery::class, 'slug', $request->name),
                'category' => 'photo',
                'description' => $request->description,
                'activity' => Carbon::parse($request->date),
            ]);

            if ($request->medias != null) {
                if(!File::isDirectory('field/'.$field->slug.'/photo/'.$media->slug)){
                    File::makeDirectory('field/'.$field->slug.'/photo/'.$media->slug, 0777, true, true);
                }
            
                foreach ($request->medias as $file) {
                    $old = 'tmp/uploads/'.$file;
                    $new = 'field/'.$field->slug.'/photo/'.$media->slug.'/'.$file;
                    File::move($old, $new);
                    $media->files()->create([
                        'name' => $file,
                        'folder' => $media->slug
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('photo.index', $gallery)->withSuccess('Berhasil menambah arsip foto: '.$media->name);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('photo.index', $gallery)->with('error', 'Gagal menambah arsip foto');
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

    public function update(Request $request, $gallery, $photo)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required'],
            'date' => ['required', 'date']
        ]);
        
        DB::beginTransaction();
        try {
            $media = Gallery::findOrFail($photo);
            $mediaOldName = $media->slug;

            $media->update([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => SlugService::createSlug(Gallery::class, 'slug', $request->name),
                'activity' => Carbon::parse($request->date),
            ]);

            if(isset($media->getChanges()['slug']) == true){
                rename('field/'.$gallery.'/photo/'.$mediaOldName, 'field/'.$gallery.'/photo/'.$media->slug);
            }

            if ($request->medias != null) {
                foreach ($request->medias as $file) {
                    $old = 'tmp/uploads/'.$file;
                    $new = 'field/'.$gallery.'/photo/'.$media->slug.'/'.$file;
                    File::move($old, $new);
                    $media->files()->create([
                        'name' => $file,
                        'folder' => $media->slug
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('photo.index', $gallery)->withSuccess('Berhasil update arsip foto: '.$media->name);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('photo.index', $gallery)->with('error', $e->getMessage());
        }
    }

    public function destroy($gallery, $photo)
    {
        try {
            $media = Gallery::findOrFail($photo);
            File::deleteDirectory('field/'.$gallery.'/photo/'.$media->slug);
            File::delete($media->name.'.zip');
            $media->delete();

            return redirect()->route('photo.index', $gallery)->withSuccess('Berhasil hapus arsip foto: '.$media->name);
        } catch (\Exception $e) {
            return redirect()->route('photo.index', $gallery)->with('error', 'Gagal menghapus arsip foto: '.$e->getMessage());
        }
    }

    public function download($gallery, $photo)
    {
        try {
            $photo = Gallery::findOrFail($photo);
            $zip_file = $photo->name.'.zip';

            $zip = new \ZipArchive();
            $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $path = public_path('field/'.$gallery.'/photo/'.$photo->files[0]->folder);
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
            return redirect()->route('photo.index', $gallery)->with('error', 'Gagal mendownload arsip foto');
        }
    }
}
