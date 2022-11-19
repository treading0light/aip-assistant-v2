<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request) {
        try {
            $attributes = $request->validate([
                'email' => ['required'],
                'password' => ['required']
            ]);
        } catch (Throwable $e) {

            $message = $e->getMessage();

            return json_encode($message);
        }

        return json_encode($attributes);
    }
}
