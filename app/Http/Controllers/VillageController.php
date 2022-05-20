<?php

namespace App\Http\Controllers;

use App\Http\Requests\VillageRequest;
use App\Models\Village;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\File;
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
            $village = Village::create([
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

            if (!File::isDirectory('village/'.$village->slug)) {
                File::makeDirectory('village/'.$village->slug, 0777, true, true);
            }

            return redirect()->route('village.index')->withSuccess('Berhasil menambah desa');
        } catch (\Exception $e) {
            return redirect()->route('village.index')->with('error', 'Gagal menambah desa');
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
            $old = $village->slug;
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

            if(isset($village->getChanges()['slug']) == true){
                rename('village/'.$old, 'village/'.$village->slug);
            }

            return redirect()->route('village.index')->withSuccess('Berhasil update desa');
        } catch (\Exception $e) {
            return redirect()->route('village.index')->with('error', 'Gagal update desa');
        }
    }

    public function destroy($id)
    {
        try {
            $village =  Village::findOrFail($id);
            $village->delete();
            File::deleteDirectory('village/'.$village->slug);
            return redirect()->route('village.index')->withSuccess('Berhasil menghapus desa');
        } catch (\Exception $e) {
            return redirect()->route('village.index')->with('error', 'Gagal menghapus desa');
        }
    }
}
