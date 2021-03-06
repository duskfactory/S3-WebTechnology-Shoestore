<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment as CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'user' => 'required|integer',
            'article' => 'required|integer'
        ]);

        if ($validator->fails())
            return response()->json(["error" => 'Validation failed.'], 400);

        $validated = $validator->validate();

        User::findOrFail($validated['user']);
        Article::findOrFail($validated['article']);

        $comment = new Comment([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'user_id' => $validated['user'],
            'article_id' => $validated['article']
        ]);

        $comment->save();

        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string'
        ]);

        if ($validator->fails())
            return response()->json(["error" => 'Validation failed.'], 400);

        $validated = $validator->validate();

        $savedComment = Comment::findOrFail($id);

        if ($validated['title'] != null)
            $savedComment->title = $validated['title'];
        if ($validated['body'] != null)
            $savedComment->body = $validated['body'];

        $savedComment->save();

        return new CommentResource($savedComment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $savedComment = Comment::findOrFail($id);
        if ($savedComment->image != null)
            Storage::delete($savedComment->image);
        $savedComment->delete();
        return response("Comment succesfully deleted");
    }

    public function uploadImage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);

        if ($validator->fails())
            return response()->json(["error" => 'Validation failed.'], 400);

        $comment = Comment::findOrFail($id);
        $path = $request->file('image')->store('comments');

        if ($comment->image != null)
            Storage::delete($comment->image);
            
        $comment->image = $path;
        $comment->save();
        return new CommentResource($comment);
    }
}
