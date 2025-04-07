<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        echo 'ok';
    }

    //================================================================
    public function logout()
    {

        echo 'Logout';
    }
}
