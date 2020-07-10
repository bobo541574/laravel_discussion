<?php

namespace App\Http\Controllers;

use App\Example;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function home()
    {
        ddd(resolve('App\Example'), resolve('App\Example'));
        return "page controller - index";
    }
}