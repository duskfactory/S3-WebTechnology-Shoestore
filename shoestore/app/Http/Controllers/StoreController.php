<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
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

    public function postComment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image'
        ]);

        if ($validator->fails())
            return back()->withErrors(['error', 'Comment body or title invalid.']);

        $validated = $validator->validate();
        $path = null;
        if ($validated['image'] != null)
            $path = $request->file('image')->store('comments');

        Comment::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'user_id' => Auth::id(),
            'article_id' => $id,
            'image' => $path
        ]);

        return back()->with('message', 'Comment succesfully posted.');
    }

    public function deleteComment($id)
    {
        $savedComment = Comment::find($id);
        if ($savedComment->image != null)
            Storage::delete($savedComment->image);
        $savedComment->delete();
        return back()->with('message', 'Comment succesfully deleted.');
    }

    public function postPurchase(Request $request)
    {
        $message = "";
        if ($request->session()->has('basket')) {
            foreach ($request->session()->get('basket') as $id)
                Auth::user()->purchases()->attach($id);
            $message = "Purchase succesfully completed.";
        } else
            $message = "Basket is empty";
            
        return view('dashboard', [
            'user' => Auth::user(),
            'message' => $message
        ]);
    }

    public function addToBasket(Request $request, $id)
    {
        $request->session()->push('basket', $id);
        return redirect()->route('checkout');
    }

    public function removeFromBasket(Request $request, $id)
    {
        $articles = $request->session()->pull('basket');
        if (($key = array_search($id, $articles)) !== false) 
            unset($articles[$key]);
        session()->put('basket', $articles);
        return redirect()->route('checkout');
    }
}
