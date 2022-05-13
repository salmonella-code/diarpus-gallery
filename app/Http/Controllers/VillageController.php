<?php

namespace App\Http\Controllers;

use App\Http\Requests\VillageRequest;
use App\Models\Village;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Yajra\DataTables\Facades\DataTables;

class VillageController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $categories = Village::query();

            return DataTables::of($categories)
                    ->addIndexColumn()
                    ->addColumn('action','village.action')
                    ->toJson();
        }
        return view('village.index');
    }

    public function create()
    {
        return view('village.create');
    }

    public function store(VillageRequest $request)
    {
        try {
            Village::create([
                'province' => $request->province,
                'regency' => $request->regency,
                'district' => $request->district,
                'village' => $request->village,
                'email' => $request->email,
                'phone' => $request->phone,
                'rw' => $request->rw,
                'rt' => $request->rt,
                'head_village' => $request->head_village,
                'slug' =>  SlugService::createSlug(Village::class, 'slug', $request->village),
            ]);
            return redirect('/village')->withSuccess('Berhasil menambah desa');
        } catch (\Exception $e) {
            return redirect('/village')->with('error', 'Gagal menambah desa '. $e->getMessage());
        }
    }

    public function show($id)
    {
        $village = Village::findOrFail($id);
        return view('village.show', compact('village'));
    }

    public function edit($id)
    {
        $village = Village::findOrFail($id);
        return view('village.edit', compact('village'));
    }

    public function update(VillageRequest $request, $id)
    {
        try {
            $village = Village::findOrFail($id);
            $village->update([
                    'province' => $request->province,
                    'regency' => $request->regency,
                    'district' => $request->district,
                    'village' => $request->village,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'rw' => $request->rw,
                    'rt' => $request->rt,
                    'head_village' => $request->head_village,
                    'slug' =>  SlugService::createSlug(Village::class, 'slug', $request->village),
                ]);
                return redirect('/village')->withSuccess('Berhasil update desa');
        } catch (\Exception $e) {
            return redirect('/village')->with('error', 'Gagal update desa '. $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $village =  Village::findOrFail($id);
            $village->delete();
            return redirect('/village')->withSuccess('Berhasil menghapus desa');
        } catch (\Exception $e) {
            return redirect('/village')->with('error', 'Gagal menghapus desa '. $e->getMessage());
        }
    }
}
