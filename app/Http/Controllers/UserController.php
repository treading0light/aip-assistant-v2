<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use App\Models\User;

class UserController extends Controller
{

    public function get(Request $request) {
        if (Auth::user()) {
            return response([
                'message' => 'success',
                'userData' => Auth::user()
            ]);
        } else {
            return response(['message' => 'no user logged in']);
        }
    }

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

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            
            return response([
                'message' => 'success',
                'userData' => Auth::user()
            ]);
        } else {
            return response([
                'message' => 'login failed'
            ]);
        }
    }

    public function logout(Request $request) {
        try {
            Auth::guard('web')->logout();

        } catch (Throwable $e) {
            $message = $e->getMessage();

            return json_encode($message);
        }

        return response(['message' => 'logout successful.']);
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

        // return json_encode($credentials);

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password'])
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return response(['message' => 'success', 'userData' => $user]);
        } else {
            return response(['message' => 'login error']);
        }

    }
}
