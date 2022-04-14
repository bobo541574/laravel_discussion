<?php

namespace App\Http\Controllers;

use App\Unlike;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnlikeController extends Controller
{
    public function unlike(Request $request)
    {
        if (Auth::check()) {
            $article = Article::findOrFail($request->article_id);

            $unlike_check = Unlike::where(['unlikeable_id' => $request->article_id, 'user_id' => auth()->user()->id])->first();

            if ($unlike_check) {
                $unlike_check->delete();

                return response()->json([
                    'status'    => 200,
                    'data'      => $unlike_check,
                    'unlikeCount' => $article->unlikeCount,
                ]);
            }

            $unlike = new Unlike();
            $unlike->user_id = auth()->user()->id;
            $unlike->unlikeable_id = $request->article_id;
            $article->unlikes()->save($unlike);
            return response()->json([
                'status'    => 201,
                'data'      => $unlike,
                'unlikeCount' => $article->unlikeCount,
            ]);
        } else {
            return 401;
        }
    }
}