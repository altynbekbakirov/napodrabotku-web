<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use \App\Models\Busyness;
use Illuminate\Http\Request;

class BusynessController extends Controller
{
    public function index(Request $request)
    {
        $result = [];
        foreach (Busyness::all() as $item){
            array_push($result, [
                'id'=> $item->id,
                'name'=> $item->getName($request->lang)
            ]);
        }

        return $result;

    }
}
