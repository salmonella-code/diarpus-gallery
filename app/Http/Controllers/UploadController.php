<?php

namespace App\Http\Controllers;

use App\Models\File as ModelsFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class UploadController extends Controller
{
    public function uploadMedia(Request $request)
    {
        try {
            if ($request->hasFile('path')) {
                $file = $request->file('path');
                $fileName = uniqid() . time() . '.' . $file->getClientOriginalExtension();
                $file->move('tmp/uploads/', $fileName);
    
                return response()->json($fileName);
            }
            return '';
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function destroyMedia(Request $request)
    {
        try {
            $payLoad = json_decode($request->getContent());
            File::delete('tmp/uploads/'.$payLoad);
            return response()->json($payLoad);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deletePhoto($gallery,$id)
    {
        try {
            $photo = ModelsFile::findOrFail($id);
            File::delete('field/'.$gallery.'/photo/'.$photo->folder.'/'.$photo->name);
            $photo->delete();
            return response()->json([
                'success' => 'Berhasil hapus data!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal hapus data!'
            ]);
        }
    }

    public function deletePhotoVillage($gallery,$id)
    {
        try {
            $photo = ModelsFile::findOrFail($id);
            File::delete('village/'.$gallery.'/photo/'.$photo->folder.'/'.$photo->name);
            $photo->delete();
            return response()->json([
                'success' => 'Berhasil hapus data!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal hapus data!'
            ]);
        }
    }
}
