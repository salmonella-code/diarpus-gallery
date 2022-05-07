<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

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

    public function update(ProfileRequest $request)
    {
        $profile = auth()->user();

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

        if($request->avatar != null){
            if ($profile->avatar != 'avatar.jpg') {
                File::delete('avatar/' . $profile->avatar);
            }
            $old = 'tmp/uploads/'.$request->avatar;
            $new = 'avatar/'.$request->avatar;
            File::move($old, $new);
    		$profile->avatar = $request->avatar;
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
