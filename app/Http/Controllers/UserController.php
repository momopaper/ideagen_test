<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\User\RegisterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the user.
     */
    public function index()
    {
        $users = User::with('roles')->where('id', '!=', Auth()->user()->id)->get();

        return view('dashboard', ['object' => 'user', 'mode' => 'list', 'users' => $users]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('components.user.user-view', ['object' => 'user', 'mode' => 'create']);
    }

    /**
     * Register new user.
     */
    public function register(Request $request)
    {
        $result = app(RegisterUser::class)->execute($request->all());

        if (!$result instanceof User) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result);
        }
        Auth::login($result);

        return redirect()->route('timesheet.index');
    }

    /**
     * Show the form for editing user.
     */
    public function edit(Request $request, User $user)
    {
        return view('components.user.user-view', ['object' => 'user', 'mode' => 'edit', 'user' => $user]);
    }
}
