<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use \App\Models\VacancyType;
use Illuminate\Http\Request;
use function Sodium\add;

class VacancyTypeController extends Controller
{
    public function index(Request $request)
    {
        $result = [];
        foreach (VacancyType::all() as $item){
            array_push($result, [
                'id'=> $item->id,
                'name'=> $item->getName($request->lang)
            ]);
        }
        return $result;

    }
}
