<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\User\CreateUser;
use App\Services\User\DeleteUser;
use App\Services\User\RegisterUser;
use App\Services\User\UpdateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the user.
     */
    public function index()
    {
        $users = User::with('roles')->get();

        return view('dashboard', ['object' => 'user', 'mode' => 'list', 'users' => $users]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('dashboard', ['object' => 'user', 'mode' => 'create']);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $result = app(CreateUser::class)->execute($request->all());

        if (!$result instanceof User) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result);
        }

        return redirect()->route('user.index');
    }

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
        return view('dashboard', ['object' => 'user', 'mode' => 'edit', 'user' => $user]);
    }

    /**
     * Update user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->request->set('id', $user->id);
        $result = app(UpdateUser::class)->execute($request->all());

        if ($result !== true) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result);
        }

        return redirect()->route('user.index');
    }

    /**
     * Remove user from storage.
     */
    public function destroy(User $user)
    {
        $result = app(DeleteUser::class)->execute(['id' => $user->id]);

        if ($result !== true) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result);
        }
        return redirect()->route('user.index');
    }
}
