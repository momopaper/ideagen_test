<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\CreateUser;
use App\Services\User\DeleteUser;
use App\Services\User\RegisterUser;
use App\Services\User\UpdateUser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $result = app(CreateUser::class)->execute($request->all());

        if ($result instanceof Validator) {
            return response()->json([
                'success' => false,
                'errors' => $result->errors()
            ], 422);
        }

        return response()->json(['success' => true, 'result' => new UserResource($result)]);
    }

    /**
     * Update user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->request->set('id', $user->id);
        $result = app(UpdateUser::class)->execute($request->all());

        if ($result instanceof Validator) {
            return response()->json([
                'success' => false,
                'errors' => $result->errors()
            ], 422);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove user from storage.
     */
    public function destroy(User $user)
    {
        $result = app(DeleteUser::class)->execute(['id' => $user->id]);

        if ($result instanceof Validator) {
            return response()->json([
                'success' => false,
                'errors' => $result->errors()
            ], 422);
        }

        return response()->json(['success' => true]);
    }
}
