<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Field;
use Illuminate\Support\Facades\Hash;
use File;

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

    public function update(UserRequest $request, User $admin)
    {
        $admin->update([
            'field_id' => $request->field,
            'nip' => $request->nip,
            'group' => $request->group,
            'position' => $request->position,
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
        ]);

        return redirect()->route('user.index')->withSuccess('Berhasil edit user');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->avatar != 'default.jpg'){
            File::delete('avatar/'.$user->avatar);
        }
        $user->delete();
        return redirect()->route('user.index')->withSuccess('Berhasil hapus user');
    }
}
