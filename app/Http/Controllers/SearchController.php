<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $validator = Validator(request()->all(), [
            'search'    => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $users = User::where('name', 'LIKE', '%' . $request->search . '%')->latest()
            ->orWhere('email', 'LIKE', '%' . $request->search . '%')
            ->get();

        $categories = Category::all();

        return view('search', compact('users', 'categories'));
    }
}