<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Field;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $fields = Field::all();
        return view('user.create', compact('fields'));
    }

    public function store(UserRequest $request)
    {
        try {
            User::create([
                'field_id' => $request->field,
                'nip' => $request->nip,
                'group' => $request->group,
                'position' => $request->position,
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'password' => Hash::make('diarpus789'),
                'role' => 'user',
                'avatar' => 'avatar.jpg'
            ]);
    
            return redirect()->route('user.index')->withSuccess('Berhasil menambah user');
        } catch (\Exception $e) {
            return redirect()->route('user.index')->withSuccess('Gagal menambah user');
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $fields = Field::all();
        return view('user.edit', compact('user', 'fields'));
    }

    public function update(UserRequest $request, $id)
    {
        try{
            $user = User::findOrFail($id);
            $user->update([
                'field_id' => $request->field,
                'nip' => $request->nip,
                'group' => $request->group,
                'position' => $request->position,
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
            ]);
    
            return redirect()->route('user.index')->withSuccess('Berhasil edit user');
        }catch (\Exception $e) {
            return redirect()->route('user.index')->withSuccess('Gagal edit user');
        }
    }

    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);
            if($user->avatar != 'avatar.jpg'){
                File::delete('avatar/'.$user->avatar);
            }
            $user->delete();
            return redirect()->route('user.index')->withSuccess('Berhasil hapus user');
        }catch (\Exception $e) {
            return redirect()->route('user.index')->withSuccess('Gagal hapus user');
        }
    }
}
