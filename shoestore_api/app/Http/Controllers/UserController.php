<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->has(['name', 'email', 'password']))
            return response('', 400);

        $users = User::all();
        foreach ($users as $user)
            if ($user->name == $request->input('name') ||
                $user->email == $request->input('email'))
                return response(
                    'User with this name or email already exists', 409)
                    ->header('Content-Type', 'text/plain');

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => 'user'
        ]);

        $user->save();

        return (new UserResource(
                    User::firstWhere('email', $request->input('email'))))
                    ->response()
                    ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource(User::findOrFail($user->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (!$request->has('id'))
            return response('', 400);

        $savedUser = User::findOrFail($request->input('id'));

        if ($user->name != '')
            $savedUser->name = $user->name;
        if ($user->password != '')
            $savedUser->password = $user->password;
        if ($user->email != '')
            $savedUser->email = $user->email;

        $savedUser->save();

        return new UserResource($savedUser);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $savedUser = User::findOrFail($user->id);
        $savedUser->delete();
        return response();
    }

    /**
     * Register the user's purchase of the specified item.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function makePurchase(Request $request) 
    {
        if (!$request->has(['user_id', 'article_id']))
            return response('', 400);

        $user = User::findOrFail($request->input('user_id'));
        Article::findOrFail($request->input('article_id'));

        $user->purchases()->attach($request->input('article_id'));
        $user->wishlist()->detach($request->input('article_id'));
        
        return response('', 201);
    }
}
