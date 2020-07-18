<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator(request()->all(), [
            'comment_id'    => 'required',
            'content'       => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $reply = new Reply();
        $reply->comment_id = $request->comment_id;
        $reply->user_id = auth()->user()->id;
        $reply->content = $request->content;
        $reply->save();

        return back();
    }
}