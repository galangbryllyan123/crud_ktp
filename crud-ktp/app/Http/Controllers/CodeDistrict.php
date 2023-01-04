<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\IdentifyCard;

class CodeDistrict extends Controller
{
    public function getProvince(Request $request)
    {
        $id = $request->input('prov');
        return response()->json(['province' => Province::find($id)]);
    }

    public function getCities(Request $request)
    {
        $code_province = $request->input('code_province');
        return response()->json(['cities' => City::where('provinces_id', $code_province)->get()]);
    }

    public function getCity(Request $request)
    {
        $id = $request->input('kab');
        return response()->json(['city' => City::find($id)]);
    }

    public function getDistricts(Request $request)
    {
        $code_city = $request->input('code_city');
        return response()->json(['districts' => District::where('cities_id', $code_city)->get()]);
    }

    public function getCode(Request $request)
    {
        $id = $request->input('kec');
        return response()->json(['districts' => District::find($id)]);
    }

    public function checkNik($nik)
    {
        $cek = IdentifyCard::where('nik', $nik)->count();
        if($cek){
            return $this->checkNik($nik + 1);
        }
        else{
            return response()->json(['nik' => $nik]);
        }
    }
}
