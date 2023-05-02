<?php

namespace App\Http\Controllers\Web;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebController extends Controller
{
    private $locale;

    public function __construct()
    {
        $this->locale = app()->getlocale();
    }

    public function index()
    {
        return view('web.index');
    }

    public function privacy()
    {
        return view('web.privacy');
    }


}
