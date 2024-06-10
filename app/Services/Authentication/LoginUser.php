<?php

namespace App\Services\Authentication;

use App\Services\BaseService;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class LoginUser extends BaseService
{
    /**
     * validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * Login user.
     *
     * @param array $data
     * @return mixed
     */
    public function execute(array $data)
    {
        try {
            $validated_result = $this->validate($data);
            if ($validated_result !== true) return $validated_result;

            return Auth::attempt(['email' => $data['email'], 'password' => $data['password']]);
        } catch (Exception $ex) {
            $this->log('error', $ex->getMessage() . PHP_EOL . PHP_EOL . $ex->getTraceAsString());
            return false;
        }
    }
}
