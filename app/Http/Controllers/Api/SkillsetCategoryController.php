<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SkillsetCategory;
use App\Models\Skillset;
use Illuminate\Http\Request;


class SkillsetCategoryController extends Controller
{
    public function index(Request $request)
    {
        $select = SkillsetCategory::all();
        $result = [];

        foreach ($select as $item){

            $skills = Skillset::where('skillset_category_id', $item->id)->pluck('name_ru')->toArray();

            array_push($result, [
                'id'=> $item->id,
                'name'=> $item->getName($request->lang),
                'skills' => $skills
            ]);

        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
