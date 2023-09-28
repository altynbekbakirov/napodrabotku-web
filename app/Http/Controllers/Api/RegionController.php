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

    public function districtsByName(Request $request)
    {
        $result = [];

        if($request->region && $request->region != ''){

            $region = Region::where('nameRu', $request->region)->orWhere('nameKg', $request->region)->first();

//            $result = District::where('region', $region->id)->orderBy('nameRu', 'asc')->pluck('id')->toArray();
            if($region){
                foreach (District::where('region', $region->id)->orderBy('nameRu', 'asc')->get() as $item){
                    $result[] = [
                        'id' => $item->id,
                        'name' => $item->getName($request->lang)
                    ];
                }
            }

        } else {
//            $result = District::orderBy('nameRu', 'asc')->pluck('id')->toArray();
            foreach (District::orderBy('nameRu', 'asc')->get() as $item){
                $result[] = [
                    'id' => $item->id,
                    'name' => $item->getName($request->lang)
                ];
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
        $resultTemp1 = [];
        $resultTemp2 = [];
        $districts = $request->districts;

        $vacancies = Vacancy::whereNotNull('region')->whereNotNull('district')->whereNotNull('metro')->whereNotNull('metro_colors')
            ->whereIn('district', $districts)->where('status', 'active')->orderBy('updated_at', 'desc')->get();

        foreach ($vacancies as $vacancy) {
            foreach ($vacancy->metro as $metro){
                if(!in_array($metro, $resultTemp1)){
                    $resultTemp1[] = $metro;
                }
            }

            if($vacancy->metro_colors){
                foreach ($vacancy->metro_colors as $key => $metro_color){
                    if(!in_array($key, $resultTemp2)){
                        $resultTemp2[$key] = $metro_color;
                    }
                }
            }
        }

        foreach ($resultTemp1 as $row){
            $result[] = [
                'name' => explode('--', $row)[0],
                'line' => count(explode('--', $row)) > 1 ? explode('--', $row)[1] : '',
                'name_line' => count(explode('--', $row)) > 1 ? explode('--', $row)[0].'\n'.explode('--', $row)[1] : explode('--', $row)[0],
                'color' => $resultTemp2[$row]
            ];
//            $result[] = ['name' => $row];
        }

//        dd($resultTemp, $resultTemp2, $result);

        return $result;
    }
}
