<?php

namespace App\Services\User;

use App\Services\BaseService;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterUser extends BaseService
{

    /**
     * validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'string',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'password' => 'required|string|max:255|confirmed',
            'ic' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'epf_no' => 'required|string|max:255',
            'socso_no' => 'required|string|max:255',
            'employee_no' => 'required|string|max:255',
        ];
    }

    /**
     * Create a User.
     *
     * @param array $data
     * @return mixed
     */
    public function execute(array $data)
    {
        try {
            $validated_result = $this->validate($data);
            if ($validated_result !== true) return $validated_result;

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'ic' => $data['ic'],
                'epf_no' => $data['epf_no'],
                'socso_no' => $data['socso_no'],
                'employee_no' => $data['employee_no']
            ]);

            $user->assignRole('user');

            return $user;
        } catch (Exception $ex) {
            $this->log('error', $ex->getMessage() . PHP_EOL . PHP_EOL . $ex->getTraceAsString());
            return false;
        }
    }
}
