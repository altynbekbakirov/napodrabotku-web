<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use \App\Models\Region;
use App\Models\Vacancy;
use App\Models\VacancyType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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

    public function regionByName(Request $request)
    {
        if($request->region){

            $region = Region::where('nameRu', $request->region)->orWhere('nameKg', $request->region)->first();

            return json_encode($region->id);

        }
        return 0;
    }

    public function districts(Request $request)
    {
        $result = [];

        if($request->region && $request->region != ''){

            $region = Region::where('nameRu', $request->region)->orWhere('nameKg', $request->region)->first();

            $result = District::where('region', $region->id)->orderBy('nameRu', 'asc')->pluck('id')->toArray();
//            if($region){
//                foreach (District::where('region', $region->id)->orderBy('nameRu', 'asc')->get() as $item){
//                    array_push($result, [
//                        'id'=> $item->id,
//                        'name'=> $item->getName($request->lang)
//                    ]);
//                }
//            }

        } else {
            $result = District::orderBy('nameRu', 'asc')->pluck('id')->toArray();
//            foreach (District::orderBy('nameRu', 'asc')->get() as $item){
//                array_push($result, [
//                    'id'=> $item->id,
//                    'name'=> $item->getName($request->lang)
//                ]);
//            }
        }
        return $result;
    }
    public function districtsByRegionId(Request $request)
    {
        $result = [];

        if($request->region){

            $region = Region::where('nameRu', $request->region)->orWhere('nameKg', $request->region)->first();

            foreach (District::where('region', $region->id)->orderBy('nameRu', 'asc')->get() as $item){
                $result[] = [
                    'id' => $item->id,
                    'name' => $item->getName($request->lang)
                ];
            }
        } else {
            foreach (District::orderBy('nameRu', 'asc')->get() as $item){
                $result[] = [
                    'id' => $item->id,
                    'name' => $item->getName($request->lang)
                ];
            }
        }
        return $result;
    }
    public function metros(Request $request)
    {
        $result = [];
        $resultTemp = [];
        $districts = $request->districts;

        $vacancies = Vacancy::whereNotNull('region')->whereNotNull('district')->whereNotNull('metro')
            ->whereIn('district', $districts)->get();

        foreach ($vacancies as $vacancy) {
            $resultTemp = Arr::collapse([$resultTemp, $vacancy->metro]);
        }

        foreach ($resultTemp as $row){
            $result[] = ['name' => $row];
        }

        return $result;
    }
}
