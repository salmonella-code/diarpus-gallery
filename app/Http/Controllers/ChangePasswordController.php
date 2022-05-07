<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('changePassword.index');
    }

    public function update(PasswordRequest $request)
    {
        try {
            $user = auth()->user();
            if (Hash::check($request->oldPassword, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->withSuccess('Berhasil update password');
        } catch (\Exception $e) {
            return redirect('change-password')->with('error', 'Gagal update password');
        }
    }
}
