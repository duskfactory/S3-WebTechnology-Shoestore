<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function showArticles()
    {
        return view('welcome', ['articles' => Article::paginate(10)]);
    }

    public function getArticle($id)
    {
        return view('article', ['article' => Article::findOrFail($id)]);
    }

    public function checkout(Request $request)
    {
        return view('checkout', ['basket' => $request->session()->get('basket')]);
    }

    public function dashboard()
    {
        return view('dashboard', ['user' => Auth::user()]);
    }

    public function postComment()
    {
        
    }

    public function postPurchase(Request $request)
    {
        if (!$request->has(['user', 'article']))
            return response('Need user and article id.', 400);

        $user = User::findOrFail($request->input('user'));
        Article::findOrFail($request->input('article'));

        $user->purchases()->attach($request->input('article'));
    }
}
