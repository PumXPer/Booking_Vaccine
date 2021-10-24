<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function loginForm()
    {
        return view('auth.login');
    }

    function authenticate(Request $request)
    {
        $data = $request->getParsedBody();
        $credentials = [
        'email' => $data['email'],
        'password' => $data['password'],
        ];

        // authenticate by using method attempt()
        if (Auth::attempt($credentials)) {
        // regenerate the new session ID
        session()->regenerate();

        // redirect to the requested URL or
        // to route product-list if does not specify
        return redirect()->intended(route('vaccine-list'));
        }

        // if cannot authenticate redirect back to loginForm with error message.
        return redirect()->back()->withErrors([
        'credentials' => 'Email or Password incorrect',
    ]);
    }

    function logout()
    {
        Auth::logout();
        session()->invalidate();

        // regenerate CSRF token
        session()->regenerateToken();

        return redirect()->route('login');

    }


}
