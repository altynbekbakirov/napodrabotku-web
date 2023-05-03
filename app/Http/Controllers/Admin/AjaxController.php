<?php

namespace App\Http\Controllers\Admin;

use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use MoveMoveIo\DaData\Enums\Language;
use MoveMoveIo\DaData\Facades\DaDataAddress;

class AjaxController extends Controller
{
    public function dadataUser(Request $request)
    {
        $dadata = DaDataAddress::prompt($request->key, 5, Language::RU, ["country_iso_code" => "*"]);
        return json_encode($dadata);
    }

    public function regions(Request $request)
    {
        $result = '';
        $regions = Region::where('country', $request->country)->get();
        foreach ($regions as $region){
            $result .= '<option value="'.$region->id.'">'.$region->nameRu.'</option>';
        }

        return $result;
    }

    public function districts(Request $request)
    {
        $result = '';
        $districts = District::where('region', $request->region)->get();
        foreach ($districts as $district){
            $result .= '<option value="'.$district->id.'">'.$district->nameRu.'</option>';
        }

        return $result;
    }
}
