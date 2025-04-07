<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //================================================================
    public function login()
    {

        return view('login');
    }

    //================================================================
    public function loginsubmit(Request $request)
    {
        // form validation
        $request->validate(
            [
                'text_username' => ['required', 'email'],
                'text_password' => ['required', 'min: 6', 'max: 20'],
            ],
            [
                'text_username.required' => 'Please enter your username.',
                'text_username.email' => 'Your username must be a valid email address.',
                'text_password.required' => 'Please enter your password.',
                'text_password.min' => 'Your password must have at least :min characters.',
                'text_password.max' => 'Your password must have at least :max characters.'
            ],
        );

        // get user input

        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // check if user exists
        $user = User::where('username', $username)->where('deleted_at', NULL)->first();

        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username or password incorrect.');
        }

        // check if password is correct
        if (!password_verify($password, $user->password)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username or password incorrect.');
        }

        // update last login
        $user->last_login = now();
        $user->save();

        // login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ]
        ]);

        echo 'Login com sucesso';
    }

    //================================================================
    public function logout()
    {

        echo 'Logout';
    }
}
