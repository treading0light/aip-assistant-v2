<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use Session;

use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request) {
        try {
            $credentials = $request->validate([
                'email' => ['required'],
                'password' => ['required']
            ]);
        } catch (Throwable $e) {

            $message = $e->getMessage();

            return response(['message' => $message]);
        }

        return response([
            'message' => $message,
            'userData' => $credentials
        ]);
    }

    public function register(Request $request) {
        try {
            $credentials = $request->validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:8']
            ]);
        } catch (Throwable $e) {

            $message = $e->getMessage();

            return json_encode($message);
        }

        $user = User::create([
            'name' => $credentials->name,
            'email' => $credentials->email,
            'password' => Hash::make($credentials->password)
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response(['message' => 'success', 'userData' => $user]);
        }


    }
}
