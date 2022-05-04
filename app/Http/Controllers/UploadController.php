<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    public function uploadMedia(Request $request)
    {
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $fileName = uniqid() . time() . '.' . $file->getClientOriginalExtension();
            $file->move('tmp/uploads/', $fileName);

            return response()->json($fileName);
        }

        return '';
    }

    public function destroyMedia(Request $request)
    {
        $payLoad = json_decode($request->getContent());
        File::delete('tmp/uploads/'.$payLoad);
        return response()->json($payLoad);
    }

    public function avatar(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $folder = uniqid().'-'.now()->timestamp;
            $file->move('avatar/tmp/'.$folder, $fileName);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $fileName,
            ]);

            return $folder;
        }

        return '';
    }

    public function video(Request $request)
    {
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $folder = uniqid().'-'.now()->timestamp;
            $file->move('video/tmp/'.$folder, $fileName);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $fileName,
            ]);

            return $folder;
        }

        return '';
    }
}
