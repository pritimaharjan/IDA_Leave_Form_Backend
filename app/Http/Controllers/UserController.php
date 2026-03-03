<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show($email)
    {
        $user = User::where('email', $email)->firstOrFail();
        $user = [

            'name' => $user->name,
            'email' => $user->email,
            'department' => $user->department ? $user->department->name : null,
            'line_manager' => $user->lineManager ? $user->lineManager->email : null,
            'designation' => $user->designation,

        ];

        return response()->json($user);
    }
}
