<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment as CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        if (!$request->has(['title', 'content', 'user_id', 'article_id']))
            return response('', 400);

        $comment = new Comment([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user' => $request->input('user_id'),
            'article' => $request->input('article_id')
        ]);

        User::findOrFail($request->input('user_id'));
        Article::findOrFail($request->input('article_id'));

        $comment->save();

        return response('', 201);
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
            return response('', 400);

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
        return response();
    }
}
