<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function photo(Request $request)
    {
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $folder = uniqid().'-'.now()->timestamp;
            $file->move('photo/tmp/'.$folder, $fileName);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $fileName,
            ]);

            return $folder;
        }

        return '';
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
