<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::all();
        return view('field.index', compact('fields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);

        Field::create([
            'name' => $request->name
        ]);

        return redirect()->route('field.index')->withSuccess('Berhasil menambah bidang');
    }

    public function edit($id)
    {
        $field = Field::findOrFail($id);
        return response()->json($field);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);

        $field = Field::findOrFail($request->id);
        $field->update([
            'name' => $request->name
        ]);

        return redirect()->route('field.index')->withSuccess('Berhasil edit bidang');
    }

    public function destroy($id)
    {
        $field = Field::findOrFail($id);
        $field->delete();
        return redirect()->route('field.index')->withSuccess('Berhasil hapus bidang');
    }
}
