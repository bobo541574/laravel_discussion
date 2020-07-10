<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('timelines.index', ['articles' => $user->timeline()->paginate(5), 'categories' => Category::all()]);
    }
}