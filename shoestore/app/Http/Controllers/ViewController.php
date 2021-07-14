<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function showArticles()
    {
        return view('welcome', ['articles' => Article::paginate(10)]);
    }

    public function getArticle($id)
    {
        $userid = -1;
        if (Auth::check())
            $userid = Auth::id();
        return view('article', [
            'article' => Article::find($id),
            'id' => $userid
        ]);
    }

    public function checkout(Request $request)
    {
        $basket = [];
        $totalSum = 0;

        if ($request->session()->has('basket'))
            foreach ($request->session()->get('basket') as $id)
                array_push($basket, Article::find($id));

        foreach ($basket as $article)
            $totalSum += $article->price;

        return view('checkout', [
            'basket' => $basket,
            'totalSum' => $totalSum
        ]);
    }

    public function dashboard()
    {
        return view('dashboard', ['user' => Auth::user()]);
    }
}
