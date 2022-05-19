<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Village;
use App\Models\VillageUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class VillageUserController extends Controller
{
    public function index()
    {
        $userVillages = User::where('role', 'village')->with('village')->get();
        return view('villages.user.index', compact('userVillages'));
    }

    public function create()
    {
        $villages = Village::all();
        return view('villages.user.create', compact('villages'));
    }

    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $village = User::create([
                'nip' => $request->nip,
                'group' => $request->group,
                'position' => $request->position,
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'password' => Hash::make('desa12345'),
                'role' => 'village',
                'avatar' => 'avatar.jpg'
            ]);

            VillageUser::create([
                'user_id' => $village->id,
                'village_id' => $request->village
            ]); 
            DB::commit();

            return redirect('/village-user')->withSuccess('Berhasil menambah user desa');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('/village-user')->with('error', 'Gagal menambah user desa ');
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
        $villages = Village::all();
        return view('villages.user.edit', compact('user', 'villages'));
    }

    public function update(UserRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $village = User::findOrFail($id);

            $village->update([
                'nip' => $request->nip,
                'group' => $request->group,
                'position' => $request->position,
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
            ]);

            $village->village()->update([
                'village_id' => $request->village,
            ]);

            DB::commit();
            
            return redirect('/village-user')->withSuccess('Berhasil edit user desa');

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
        return redirect('/village-user')->withSuccess('Berhasil hapus user desa');
    }
}
