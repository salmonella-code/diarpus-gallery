<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;

class UtilitiesController extends Controller
{
    public function regency(Request $request)
    {
        $province_id = $request->id;

        $regencies = Regency::where('province_id', $province_id)->pluck('name', 'id');
        return $regencies;
    }

    public function district(Request $request)
    {
        $regency_id = $request->id;

        $districts = District::where('regency_id', $regency_id)->pluck('name', 'id');
        return $districts;
    }

    public function village(Request $request)
    {
        $district_id = $request->id;

        $villages = Village::where('district_id', $district_id)->pluck('name', 'id');

        return $villages;
    }
}
