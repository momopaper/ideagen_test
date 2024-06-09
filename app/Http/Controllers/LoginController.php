<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Auth\StatefulGuard;

class LoginController extends Controller
{
    /**
     * Display login form.
     */
    public function showLoginForm()
    {
        if (Auth()->user()) {
            return redirect()->route('timesheet.index');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Login.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout;
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
