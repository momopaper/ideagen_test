<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\User\CreateUser;
use App\Services\User\DeleteUser;
use App\Services\User\UpdateUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();

        return view('dashboard', ['object' => 'user', 'mode' => 'list', 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard', ['object' => 'user', 'mode' => "create"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->request->set('user_id', $request->user()->id);
        $result = app(CreateUser::class)->execute($request->all());

        if (!$result instanceof User) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result);
        }

        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {
        return view('dashboard', ['object' => 'user', 'mode' => "edit", 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
