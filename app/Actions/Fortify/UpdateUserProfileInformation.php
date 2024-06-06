<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        $id = $input['id'];
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->where(function ($query) use ($id) {
                $query->whereNull('deleted_at')->where('id', '!=', $id);
            }),],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'ic' => ['required', 'string', 'max:255', Rule::unique('users')->where(function ($query) use ($id) {
                $query->whereNull('deleted_at')->where('id', '!=', $id);
            }),],
            'epf_no' => ['required', 'string', 'max:255'],
            'socso_no' => ['required', 'string', 'max:255'],
            'employee_no' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'ic' => $input['ic'],
                'epf_no' => $input['epf_no'],
                'socso_no' => $input['socso_no'],
                'employee_no' => $input['employee_no']
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
