<?php

namespace App\Http\Controllers;

use App\Services\Authentication\LoginUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $result = app(LoginUser::class)->execute($request->all());

        if ($result instanceof Validator) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result);
        }

        if ($result == true) {
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
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
