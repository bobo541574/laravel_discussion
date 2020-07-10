<?php

namespace App\Http\Controllers;

use App\Like;
use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like()
    {
        if (Auth::check()) {
            $article = Article::find(request('id'));

            if ($article->likeCheck) {
                $like = Like::where(['likeable_id' => request('id'), 'user_id' => auth()->user()->id])->first();
                $like->delete();
                return response()->json([
                    'status' => 200,
                    'data' => $like,
                    'likeCount' => $article->likeCount,
                    'dislikeCount' => $article->dislikeCount,
                ]);
            }
            return response()->json([
                'status' => 201,
                'data' => $article->likeArticle(auth()->user()->id, (int) request('id'), true),
                'likeCount' => $article->likeCount,
                'dislikeCount' => $article->dislikeCount,
            ]);
        } else {
            return 401;
        }

        // if (Auth::check()) {
        //     $article = Article::findOrFail($request->id);

        //     if ($article->likeCheck) {
        //         $like = Like::where(['likeable_id' => $request->id, 'user_id' => auth()->user()->id])->first();

        //         $like->delete();

        //         return response()->json([
        //             'status' => 200,
        //             'data' => $like,
        //             'likeCount' => $article->likeCount,
        //         ]);
        //     }

        //     $like = new Like();
        //     $like->user_id = auth()->user()->id;
        //     $like->likeable_id = $request->id;
        //     $like->liked = true;
        //     $article->likes()->save($like);
        //     return response()->json([
        //         'status' => 201,
        //         'data' => $like,
        //         'likeCount' => $article->likeCount,
        //     ]);
        // } else {
        //     return 401;
        // }
    }

    public function dislike(Article $article)
    {
        if (Auth::check()) {
            $article = Article::find(request('id'));

            if ($article->dislikeCheck) {
                $like = Like::where(['likeable_id' => request('id'), 'user_id' => auth()->user()->id])->first();
                $like->delete();
                return response()->json([
                    'status' => 200,
                    'data' => $like,
                    'dislikeCount' => $article->dislikeCount,
                    'likeCount' => $article->likeCount,
                ]);
            }
            return response()->json([
                'status' => 201,
                'data' => $article->likeArticle(auth()->user()->id, (int) request('id'), false),
                'dislikeCount' => $article->dislikeCount,
                'likeCount' => $article->likeCount,
            ]);
        } else {
            return 401;
        }
    }

    public function likeComment(Request $request)
    {
        if (Auth::check()) {
            $comment = Comment::findOrFail($request->id);

            $like_check = Like::where(['likeable_id' => $request->id, 'user_id' => auth()->user()->id])->first();

            if ($like_check) {
                $like_check->delete();

                return response()->json([
                    'status' => 200,
                    'data' => $like_check,
                    'likeCount' => $comment->likeCount,
                ]);
            }

            $like = new Like();
            $like->user_id = auth()->user()->id;
            $like->likeable_id = $request->id;
            $comment->likes()->save($like);
            return response()->json([
                'status' => 201,
                'data' => $like,
                'likeCount' => $comment->likeCount,
            ]);
        } else {
            return 401;
        }
    }
}