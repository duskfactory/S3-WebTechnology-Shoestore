<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function postComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image',
            'articleId' => 'required'
        ]);

        if ($validator->fails())
            return redirect("/article/{$request->input('articleId')}");

        $validated = $validator->validate();
        $path = null;
        if (array_key_exists('image', $validated))
            $path = $request->file('image')->store('comments');

        Comment::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'user_id' => Auth::id(),
            'article_id' => $validated['articleId'],
            'image' => $path
        ]);

        return redirect("/article/{$request->input('articleId')}");
    }

    public function deleteComment($id)
    {
        $savedComment = Comment::find($id);
        if ($savedComment->image != null)
            Storage::delete($savedComment->image);
        $savedComment->delete();
        return back()->with('message', 'Comment succesfully deleted.');
    }
}
