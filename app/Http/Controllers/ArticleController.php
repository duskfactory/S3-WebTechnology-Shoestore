<?php

namespace App\Http\Controllers;

use App\Http\Resources\Article as ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ArticleResource::collection(Article::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->has(['name', 'price']))
            return response('', 400);

        $articles = Article::all();
        foreach ($articles as $article)
            if ($article->name == $request->input('name'))
                return response('Article already exists', 409)
                    ->header('Content-Type', 'text/plain');

        $article = new Article([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'image' => $request->photo->store('articles', 'public')
        ]);

        $article->save();

        return (new ArticleResource(
                    Article::latest('created_at')->first()))
                    ->response()
                    ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return new ArticleResource(Article::findOrFail($article->id));
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
        if (!$request->has('id') && !$request->hasFile('photo'))
            return response('', 400);

        $savedArticle = Article::findOrFail($request->input('id'));

        if ($article->name != '')
            $savedArticle->name = $article->name;
        if ($article->price != 0)
            $savedArticle->price = $article->price;
        if ($request->hasFile('photo')) {
            Storage::delete($savedArticle->image);
            $savedArticle->image = $request->photo->store('articles', 'public');
        }

        $savedArticle->save();

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
        Storage::delete($savedArticle->image);
        $savedArticle->delete();
        return response();
    }
}
