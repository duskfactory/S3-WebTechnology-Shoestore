<?php

namespace App\Http\Controllers;

use App\Http\Resources\Article as ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ArticleResource::collection(Article::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $articles = Article::all();
        foreach ($articles as $article)
            if ($article->name == $request->name)
                return new Response('Duplicate article', 409)
                    ->header('Content-Type', 'text/plain');

        $article = new Article([
            'name' => $request->name,
            'price' => $request->price
        ]);

        $article->save()

        return (new ArticleResource(
            Article::firstWhere('name', $request->name)
        ))->response($status = 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return new ArticleResource(
            Article::where('id', $article->id)->firstOrFail()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $savedArticle = Article::findOrFail($request->id);

        $savedArticle->name = $article->name;
        $savedArticle->price = $article->price;
        $savedArticle->image = $article->image;

        $savedArticle->save()

        return new ArticleResource($savedArticle);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $savedArticle = Article::findOrFail($article->id);
        $savedArticle->delete();
        return new Response();
    }
}
