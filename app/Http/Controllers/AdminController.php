<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Field;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use File;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        $fields = Field::all();
        return view('admin.create', compact('fields'));
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
            'role' => 'admin',
            'avatar' => 'avatar.jpg'
        ]);

        return redirect()->route('admin.index')->withSuccess('Berhasil menambah admin');
    }

    public function show($id)
    {
        $admin = User::findOrFail($id);
        $fields = Field::all();
        return view('admin.show', compact('admin', 'fields'));
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        $fields = Field::all();
        return view('admin.edit', compact('admin', 'fields'));
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

        return redirect()->route('admin.index')->withSuccess('Berhasil edit admin');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        if($admin->avatar != 'avatar.jpg'){
            File::delete('avatar/'.$admin->avatar);
        }
        $admin->delete();
        return redirect()->route('admin.index')->withSuccess('Berhasil hapus admin');
    }
}
