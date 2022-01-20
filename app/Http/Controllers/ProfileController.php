<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use File;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', ['profile' => auth()->user()]);
    }

    public function edit()
    {
        return view('profile.edit', ['profile' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $profile = auth()->user();
        $request->validate([
            'nip' => ['nullable', 'numeric', Rule::unique('users', 'nip')->ignore($profile->id)],
            'group' => ['nullable', 'string'],
            'position' => ['required', 'string'],
            'name' => ['required', 'string'],
            'contact' => ['required', 'numeric', Rule::unique('users', 'contact')->ignore($profile->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($profile->id)],
        ]);

        $profile->nip = $request->nip;
        $profile->group = $request->group;
        $profile->position = $request->position;
        $profile->name = $request->name;
        $profile->contact = $request->contact;
        $profile->email = $request->email;

        if ($request->password != null) {
            $request->validate([
                'password' => ['string', 'min:8', 'confirmed'],
            ]);
            $profile->password = Hash::make($request->password);
        }

        $temporaryFile = TemporaryFile::where('folder', $request->avatar)->first();
        if ($temporaryFile) {
            if ($profile->avatar != 'avatar.jpg') {
                File::delete('avatar/' . $profile->avatar);
            }
            $old = 'avatar/tmp/' . $temporaryFile->folder . '/' . $temporaryFile->filename;
            $new = 'avatar/' . $temporaryFile->filename;
            File::move($old, $new);
            $profile->avatar = $temporaryFile->filename;
            rmdir('avatar/tmp/' . $temporaryFile->folder);
            $temporaryFile->delete();
        }

        $profile->save();

        $emailCheck = isset($profile->getChanges()['email']);
        $passwordCeck = isset($profile->getChanges()['password']);
        if ($emailCheck == true || $passwordCeck == true) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }

        return redirect()->route('profile.index')->withSuccess('Berhasil edit profile');
    }
}
