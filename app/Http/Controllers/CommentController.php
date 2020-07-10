<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()) {
            $request->validate([
                'article_id'    => "required",
                'content'       => "required"
            ]);
    
            $comment = new Comment();
            $comment->content = $request->content;
            $comment->article_id = $request->article_id;
            $comment->user_id = auth()->user()->id;
            $comment->save();
    
            return back();
        }
        return back()->with('error', "You need to login!!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content'   => "required",
        ]);

        $comment = Comment::findOrFail($id);
        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('articles.show', $comment->article_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if (Gate::allows('delete', $comment)) {
            // $comment->delete();
            return back()->with("success", "Succefully Deleted!!!");
        };

        return back()->with("error", "Unauthorize!!!");
    }
}