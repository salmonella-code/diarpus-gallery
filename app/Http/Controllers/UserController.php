<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Field;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::role('user')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $fields = Field::all();
        return view('user.create', compact('fields'));
    }

    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'nip' => $request->nip,
                'group' => $request->group,
                'position' => $request->position,
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'password' => Hash::make('diarpus789'),
                'avatar' => 'avatar.jpg'
            ]);

            $user->assignRole('user');

            $user->field()->attach($request->field);

            DB::commit();
    
            return redirect()->route('user.index')->withSuccess('Berhasil menambah user: '. $user->name);
        } catch (\Exception $e) {
            DB::rollBack();

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
        DB::beginTransaction();
        try{
            $user = User::findOrFail($id);

            $user->update([
                'nip' => $request->nip,
                'group' => $request->group,
                'position' => $request->position,
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
            ]);
    
            $user->field()->sync($request->field);

            DB::commit();

            return redirect()->route('user.index')->withSuccess('Berhasil edit user: '. $user->name);
        }catch (\Exception $e) {
            DB::rollBack();
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
            return redirect()->route('user.index')->withSuccess('Berhasil hapus user: '. $user->name);
        }catch (\Exception $e) {
            return redirect()->route('user.index')->withSuccess('Gagal hapus user');
        }
    }
}
