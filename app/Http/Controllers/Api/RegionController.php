<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use \App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        $result = [];
        foreach (Region::orderBy('nameRu', 'asc')->get() as $item){
            array_push($result, [
                'id'=> $item->id,
                'name'=> $item->getName($request->lang)
            ]);
        }
        return $result;
    }
    public function districts(Request $request)
    {
        $result = [];

        if($request->region && $request->region != ''){

            $region = Region::where('nameRu', $request->region)->orWhere('nameKg', $request->region)->first();

            foreach (District::where('region', $region->id)->orderBy('nameRu', 'asc')->get() as $item){
                array_push($result, [
                    'id'=> $item->id,
                    'name'=> $item->getName($request->lang)
                ]);
            }
        } else {
            foreach (District::orderBy('nameRu', 'asc')->get() as $item){
                array_push($result, [
                    'id'=> $item->id,
                    'name'=> $item->getName($request->lang)
                ]);
            }
        }
        return $result;
    }
    public function districtsByRegionId(Request $request)
    {
        $result = [];

        if($request->region){

            $region = Region::where('nameRu', $request->region)->orWhere('nameKg', $request->region)->first();

            foreach (District::where('region', $region->id)->orderBy('nameRu', 'asc')->get() as $item){
                array_push($result, [
                    'id'=> $item->id,
                    'name'=> $item->getName($request->lang)
                ]);
            }
        } else {
            foreach (District::orderBy('nameRu', 'asc')->get() as $item){
                array_push($result, [
                    'id'=> $item->id,
                    'name'=> $item->getName($request->lang)
                ]);
            }
        }
        return $result;
    }
}
