<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $client_info = file_get_contents('https://get.geojs.io/v1/dns/ptr.json');
        // dd(json_decode($client_info));

        $articles = Article::latest()->paginate(5);

        $categories = Category::all();

        return view('articles.index', ['articles' => $articles, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     "title" => "required",
        //     "body"  => "required",
        //     "category_id" => "required",
        // ]);

        $validator = validator(request()->all(), [
            'title'         => 'required',
            'body'          => 'required',
            'category_id'   => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = new Article();
        $article->title = $request->title;
        $article->body = $request->body;
        $article->user_id = auth()->user()->id;
        $article->category_id = $request->category_id;
        $article->save();

        return redirect()->route("articles.index")->with("success", "Succefully Created!!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $categories = Category::all();

        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $validator = Validator(request()->all(), [
            'title'         => 'required',
            'body'          => 'required',
            'category_id'   => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();

        return redirect()->route('articles.show', $article->id)->with('success', "Succefully Updated!!!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Successfully deleted!!!');
    }
}