<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skillset;
use Illuminate\Http\Request;

class SkillsetController extends Controller
{
    public function index(Request $request)
    {
        
        $select = Skillset::all();
        $result = [];

        foreach ($select as $item) {
            $result[] = [
                'id'=> $item->id,
                'name'=> $item->getName("ru"),
                'category_id' => $item->skillset_category_id,
            ];
        }

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
