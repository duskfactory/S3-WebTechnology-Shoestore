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
        return view('article', ['article' => Article::find($id)]);
    }

    public function checkout(Request $request)
    {
        $basket = [];
        if ($request->session()->has('basket'))
            foreach ($request->session()->get('basket') as $id)
                array_push($basket, Article::find($id));
        return view('checkout', ['basket' => $basket]);
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

    public function updateComment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'image' => 'nullable|image'
        ]);

        if ($validator->fails())
            return back()->withErrors(['error', 'Comment invalid.']);

        $validated = $validator->validate();
        $savedComment = Comment::find($id);

        if ($validated['title'] != null)
            $savedComment->title = $validated['title'];
        if ($validated['body'] != null)
            $savedComment->body = $validated['body'];
        if ($validated['image'] != null) {
            $path = $request->file('image')->store('comments');
            if ($savedComment->image != null)
                Storage::delete($savedComment->image);
            $savedComment->image = $path;
        }

        $savedComment->save();

        return back()->with('message', 'Comment succesfully updated.');
    }

    public function deleteComment($id)
    {
        $savedComment = Comment::find($id);
        if ($savedComment->image != null)
            Storage::delete($savedComment->image);
        $savedComment->delete();
        return back()->with('message', 'Comment succesfully deleted.');
    }

    public function postPurchase($id)
    {
        if ($request->session()->has('basket'))
            foreach ($request->session()->get('basket') as $id)
                Auth::user()->purchases()->attach($id);
        return view('dashboard', [
            'user' => Auth::user(),
            'message' => 'Purchase succesfully completed.'
        ]);
    }
}
