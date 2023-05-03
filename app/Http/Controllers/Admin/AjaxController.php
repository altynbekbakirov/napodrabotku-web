<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Main;
use MoveMoveIo\DaData\Enums\Language;
use MoveMoveIo\DaData\Facades\DaDataAddress;

class AjaxController extends Controller
{
    public function dadataUser(Request $request)
    {
        $dadata = DaDataAddress::prompt($request->key, 5, Language::RU, ["country_iso_code" => "*"]);
        return json_encode($dadata);
    }
}
