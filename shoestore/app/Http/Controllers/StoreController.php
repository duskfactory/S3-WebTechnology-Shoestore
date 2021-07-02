<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
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

    public function postComment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string'
        ]);

        if ($validator->fails())
            return back()->withErrors(['error', 'Comment body or title invalid.']);

        $validated = $validator->validate();

        Comment::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'user_id' => Auth::id(),
            'article_id' => $id
        ]);

        return back()->with('message', 'Comment succesfully posted.');
    }

    public function updateComment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string'
        ]);

        if ($validator->fails())
            return back()->withErrors(['error', 'Comment body or title invalid.']);

        $validated = $validator->validate();
        $savedComment = Comment::find($id);

        if ($validated['title'] != null)
            $savedComment->title = $validated['title'];
        if ($validated['body'] != null)
            $savedComment->body = $validated['body'];

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
        Auth::user()->purchases()->attach($id);
        return view('dashboard', [
            'user' => Auth::user(),
            'message' => 'Purchase succesfully completed.'
        ]);
    }
}
