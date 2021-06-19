<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment as CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
            'content' => 'required|string',
            'user' => 'required|integer',
            'article' => 'required|integer'
        ]);

        if ($validator->fails())
            return response()->json(["error" => 'Validation failed.'], 400);

        $validated = $validator->validate();

        $comment = new Comment([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user' => $validated['user'],
            'article' => $validated['article']
        ]);

        User::findOrFail($validated['user']);
        Article::findOrFail($validated['article']);

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
    public function update(Request $request, Comment $comment)
    {
        if (!$request->has('id'))
            return response()->json(["error" => "Request must have comment id."], 400);

        $savedComment = Comment::findOrFail($request->input('id'));

        if ($comment->title != '')
            $savedComment->title = $comment->title;
        if ($comment->content != '')
            $savedComment->content = $comment->content;

        $savedComment->save();

        return new CommentResource($savedComment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $savedComment = Comment::findOrFail($comment->id);
        $savedComment->delete();
        return response("Comment succesfully deleted");
    }
}
