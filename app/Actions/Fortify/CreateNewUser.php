<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->whereNull('deleted_at')],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'ic' => ['required', 'string', 'max:255', Rule::unique('users')->whereNull('deleted_at')],
            'epf_no' => ['required', 'string', 'max:255'],
            'socso_no' => ['required', 'string', 'max:255'],
            'employee_no' => ['required', 'string', 'max:255'],
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'ic' => $input['ic'],
            'epf_no' => $input['epf_no'],
            'socso_no' => $input['socso_no'],
            'employee_no' => $input['employee_no'],
        ]);

        //assign role
        $user->assignRole('user');

        return $user;
    }
}
