<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
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
        $users = User::all();
        foreach ($users as $user)
            if ($user->name == $request->name
                || $user->email == $request->email)
                return new Response(
                    'User with this name or email already exists',
                    409)->header('Content-Type', 'text/plain');

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user'
        ]);

        $user->save();

        return (new UserResource(
            User::firstWhere('name', $request->name)
        ))->response($status = 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return UserResource(User::findOrFail($request->id));
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
        $savedUser = User::findOrFail($request->id);

        if ($user->name != '')
            $savedUser->name = $user->name;
        if ($user->password != '')
            $savedUser->password = $user->password;
        if ($user->email != '')
            $savedUser->email = $user->email;

        $flight->save();

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
        return new Response;
    }
}
