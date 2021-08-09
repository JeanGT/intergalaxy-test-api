<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function employees()
    {
        $users = User::where('role_id', 1)->orderBy('name')->get();

        return response()->json($users);
    }
}
