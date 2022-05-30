<?php

namespace App\Http\Controllers;

use App\Http\Requests\VillageRequest;
use App\Models\ActiveVillage;
use App\Models\Province;
use App\Models\Village;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ActiveVillageController extends Controller
{
    public function village($id)
    {
        $village = Village::where('id', $id)->firstOrFail();

        return $village;
    }
    public function index(Request $request){
        if ($request->ajax()) {
            $model = ActiveVillage::with('village.district');

            return DataTables::eloquent($model)
                    ->addIndexColumn()
                    ->addColumn('action','activeVillage.action')
                    ->addColumn('village', function (ActiveVillage $activeVillage) {
                        return $activeVillage->village->district->name;
                    })
                    ->toJson();
        }
        return view('activeVillage.index');
    }

    public function create()
    {
        $provinces = Province::all();
        return view('activeVillage.create', compact('provinces'));
    }

    public function store(VillageRequest $request)
    {
        try {
            $village = ActiveVillage::create([
                'village_id' => $request->village,
                'name' => 'DESA '.$this->village($request->village)->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'rw' => $request->rw,
                'rt' => $request->rt,
                'head_village' => $request->head_village,
                'slug' =>  SlugService::createSlug(ActiveVillage::class, 'slug', 'DESA '.$this->village($request->village)->name),
            ]);

            if (!File::isDirectory('village/'.$village->slug)) {
                File::makeDirectory('village/'.$village->slug, 0777, true, true);
                File::makeDirectory('village/'.$village->slug.'/leter-c', 0777, true, true);
                File::makeDirectory('village/'.$village->slug.'/photo', 0777, true, true);
                File::makeDirectory('village/'.$village->slug.'/video', 0777, true, true);
            }

            return redirect()->route('village.index')->withSuccess('Berhasil menambah desa: '.$village->name);
        } catch (\Exception $e) {
            return redirect()->route('village.index')->with('error', 'Gagal menambah desa');
        }
    }

    public function show($id)
    {
        $village = ActiveVillage::with('village.district.regency')->findOrFail($id);
        return view('activeVillage.show', compact('village'));
    }

    public function edit($id)
    {
        $village = ActiveVillage::with('village.district.regency')->findOrFail($id);
        $provinces = Province::all();
        return view('activeVillage.edit', compact('village', 'provinces'));
    }

    public function update(VillageRequest $request, $id)
    {
        try {
            $village = ActiveVillage::findOrFail($id);
            $old = $village->slug;
            $village->update([
                    'village_id' => $request->village,
                    'name' => 'DESA '.$this->village($request->village)->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'rw' => $request->rw,
                    'rt' => $request->rt,
                    'head_village' => $request->head_village,
                    'slug' =>  SlugService::createSlug(ActiveVillage::class, 'slug', 'DESA '.$this->village($request->village)->name),
                ]);

            if(isset($village->getChanges()['slug']) == true){
                rename('village/'.$old, 'village/'.$village->slug);
            }

            return redirect()->route('village.index')->withSuccess('Berhasil update desa: '.$village->name);
        } catch (\Exception $e) {
            return redirect()->route('village.index')->with('error', 'Gagal update desa');
        }
    }

    public function destroy($id)
    {
        try {
            $village =  ActiveVillage::findOrFail($id);
            $village->delete();
            File::deleteDirectory('village/'.$village->slug);
            return redirect()->route('village.index')->withSuccess('Berhasil menghapus desa: '.$village->name);
        } catch (\Exception $e) {
            return redirect()->route('village.index')->with('error', 'Gagal menghapus desa');
        }
    }
}
