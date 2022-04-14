<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function timeline($id)
    {
        $user = User::find($id);

        $articles = $user->articles;

        $categories = Category::all();

        return view('profiles.index', compact('articles', 'categories'));
    }
}