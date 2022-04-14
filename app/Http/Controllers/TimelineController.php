<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function timeline()
    {
        $articles = auth()->user()->timeline();

        dd($articles);
    }
}