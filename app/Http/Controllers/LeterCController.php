<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeterCRequest;
use App\Models\ActiveVillage;
use App\Models\LeterC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class LeterCController extends Controller
{
    function finder($slug)
    {
        $result =  ActiveVillage::where('slug',$slug)->firstOrFail();
        return $result;
    }

    public function index(Request $request, $village){
        $dataVillage = $this->finder($village);
        if ($request->ajax()) {
            $model = LeterC::where('village_id', $dataVillage->id);

            return DataTables::eloquent($model)
                    ->addIndexColumn()
                    ->addColumn('village', $village)
                    ->addColumn('action','villages.leterC.action')
                    ->toJson();
        }
        return view('villages.leterC.index', compact('village', 'dataVillage'));
    }

    public function create($village)
    {
        return view('villages.leterC.create', compact('village'));
    }

    public function store(LeterCRequest $request, $village)
    {
        $dataVillage = $this->finder($village);
        try {
            $LeterC = LeterC::create([
                'village_id' => $dataVillage->id,
                'register_number' => $request->register_number,
                'bin' => $request->bin,
                'name' => $request->name,
                'address' => $request->address,
                'scan' => $request->scan,
            ]);

            if (!File::isDirectory('village/'.$village.'/leter-c')) {
                File::makeDirectory('village/'.$village.'/leter-c', 0777, true, true);
            }
            
            $old = 'tmp/uploads/'.$request->scan;
            $new = 'village/'.$village.'/leter-c/'.$request->scan;
            File::move($old, $new);

            return redirect()->route('village.leterC.index', $village)->withSuccess('Berhasil menambah data leter c: '. $LeterC->name);
        } catch (\Exception $e) {
            return redirect()->route('village.leterC.index', $village)->with('error', 'Gagal menambah data leter c');
        }
    }

    public function show($village, $id)
    {
        $leterC = LeterC::findOrFail($id);

        return view('villages.leterC.show', compact('village', 'leterC'));
    }

    public function edit($village, $id)
    {
        $leterC = LeterC::findOrFail($id);

        return view('villages.leterC.edit', compact('village', 'leterC'));
    }

    public function update($village, $id, LeterCRequest $request)
    {
        try {
            $leterC = LeterC::findOrFail($id);
            $oldScan = $leterC->scan;

            $leterC->update([
                'register_number' => $request->register_number,
                'bin' => $request->bin,
                'name' => $request->name,
                'address' => $request->address,
            ]);

            if($request->scan !=  null){
                $leterC->update([
                    'scan' => $request->scan,
                ]);
                File::delete('village/'.$village.'/leter-c/'.$oldScan);
                $old = 'tmp/uploads/'.$request->scan;
                $new = 'village/'.$village.'/leter-c/'.$request->scan;
                File::move($old, $new);
            }

            return redirect()->route('village.leterC.index', $village)->withSuccess('Berhasil update data leter c: '. $leterC->name);
        } catch (\Exception $e) {
            return redirect()->route('village.leterC.index', $village)->with('error', 'Gagal update data leter c');
        }
    }

    public function destroy($village, $id)
    {
        try {
            $leterC = LeterC::findOrFail($id);
            File::delete('village/'.$village.'/leter-c/'.$leterC->scan);
            $leterC->delete();
            
            return redirect()->route('village.leterC.index', $village)->withSuccess('Berhasil hapus data leter c: '. $leterC->name);
        } catch (\Exception $e) {
            return redirect()->route('village.leterC.index', $village)->with('error', 'Gagal hapus data leter c');
        }
    }
}
