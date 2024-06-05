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
    public function showLoginForm()
    {
        if (Auth()->user()) {
            return redirect()->route('timesheet.index');
        } else {
            return view('auth.login');
        }
    }

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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function logoutFromOtherBrowser(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        if (!Hash::check($request->get('password'), Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }

        $a = Auth::logoutOtherDevices($request->get('password'));
        return true;

        // $this->resetErrorBag();

        // if (!Hash::check($this->password, Auth::user()->password)) {
        //     throw ValidationException::withMessages([
        //         'password' => [__('This password does not match our records.')],
        //     ]);
        // }

        // $guard->logoutOtherDevices($this->password);

        // $this->deleteOtherSessionRecords();

        // request()->session()->put([
        //     'password_hash_' . Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
        // ]);

        // $this->confirmingLogout = false;

        // $this->dispatch('loggedOut');
    }
}
