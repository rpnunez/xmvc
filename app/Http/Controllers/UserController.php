<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Http\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return Response::json($users);
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return new Response("User not found", 404);
        }

        return new Response(view('user.show', ['user' => $user]));
    }

    public function create(Request $request)
    {
        $user = User::create($request->all());
        return Response::json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return Response::json($user);
    }

    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();
        return new Response('', 204);
    }
}