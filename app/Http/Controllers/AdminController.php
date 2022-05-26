<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Field;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::role('admin')->get();
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        $fields = Field::all();
        return view('admin.create', compact('fields'));
    }

    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $admin = User::create([
                'nip' => $request->nip,
                'group' => $request->group,
                'position' => $request->position,
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'password' => Hash::make('diarpus789'),
                'avatar' => 'avatar.jpg'
            ]);

            $admin->assignRole('admin');

            $admin->field()->attach($request->field);

            DB::commit();
            
            return redirect()->route('admin.index')->withSuccess('Berhasil menambah admin: '. $admin->name);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.index')->withSuccess('Gagal menambah admin');
        }

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

    public function update(UserRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $admin = User::findOrFail($id);

            $admin->update([
                'nip' => $request->nip,
                'group' => $request->group,
                'position' => $request->position,
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
            ]);

            $admin->field()->sync($request->field);
    
            DB::commit();

            return redirect()->route('admin.index')->withSuccess('Berhasil edit admin: '. $admin->name);
        }catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.index')->withSuccess('Gagal edit admin');
        }
    }

    public function destroy($id)
    {
        try{
            $admin = User::findOrFail($id);
            if($admin->avatar != 'avatar.jpg'){
                File::delete('avatar/'.$admin->avatar);
            }
            $admin->delete();
            return redirect()->route('admin.index')->withSuccess('Berhasil hapus admin: '. $admin->name);
        }catch (\Exception $e) {
            return redirect()->route('admin.index')->withSuccess('Gagal hapus admin');
        }
    }
}
