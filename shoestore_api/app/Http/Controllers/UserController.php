<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:App\Models\User,name',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required|alpha_dash'
        ]);

        if ($validator->fails())
            return response()->json(["error" => 'Validation failed.'], 400);

        $validated = $validator->validate();

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password']
        ]);

        $user->save();

        return new UserResource($user);
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
            return response('You must supply an id.', 400);

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
        return response("User succesfully deleted.");
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
            return response('Need user and article id.', 400);

        $user = User::findOrFail($request->input('user_id'));
        Article::findOrFail($request->input('article_id'));

        $user->purchases()->attach($request->input('article_id'));
        
        return response('Purchase succesfully registered.', 201);
    }
}
