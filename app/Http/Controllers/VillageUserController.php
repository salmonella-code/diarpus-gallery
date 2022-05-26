<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\ActiveVillage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class VillageUserController extends Controller
{
    public function index()
    {
        $userVillages = User::role('village')->get();
        return view('villages.user.index', compact('userVillages'));
    }

    public function create()
    {
        $villages = ActiveVillage::all();
        return view('villages.user.create', compact('villages'));
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

            $user->assignRole('village');

            $user->village()->attach($request->village);

            DB::commit();

            return redirect('/village-user')->withSuccess('Berhasil menambah user desa: '.$user->name);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('/village-user')->with('error', 'Gagal menambah user desa '.$e->getMessage());
        }
    }

    public function show($id)
    {
        $village = User::findOrFail($id);
        return view('villages.user.show', compact('village'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $villages = ActiveVillage::all();
        return view('villages.user.edit', compact('user', 'villages'));
    }

    public function update(UserRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            $user->update([
                'nip' => $request->nip,
                'group' => $request->group,
                'position' => $request->position,
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
            ]);
    
            $user->village()->sync($request->village);

            DB::commit();
            
            return redirect('/village-user')->withSuccess('Berhasil edit user desa: '.$user->name);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('/village-user')->withSuccess('Gagal edit user desa ');
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->avatar != 'avatar.jpg'){
            File::delete('avatar/'.$user->avatar);
        }
        $user->delete();
        return redirect('/village-user')->withSuccess('Berhasil hapus user desa: '.$user->name);
    }
}
