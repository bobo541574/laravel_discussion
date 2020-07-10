<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('timelines.index', ['articles' => $user->timeline()->paginate(5), 'categories' => Category::all()]);
    }

    public function profile($id)
    {
        dd($id);
    }

    public function edit(User $user)
    {
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $validator = validator(request()->all(), [
            'name'  => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user->name = request('name');
        if (request('photo')) {
            $user->photo = request('photo')->store('users');
        }
        $user->save();

        return redirect()->route('articles.index')->with('success', "Successfully Updated!!!");
    }
}