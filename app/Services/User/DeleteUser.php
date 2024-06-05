<?php

namespace App\Services\User;

use App\Services\BaseService;
use App\Models\User;
use Exception;

class DeleteUser extends BaseService
{
    /**
     * validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:users,id',
        ];
    }

    /**
     * Update a User.
     *
     * @param array $data
     * @return mixed
     */
    public function execute(array $data)
    {
        try {
            $validated_result = $this->validate($data);
            if ($validated_result !== true) return $validated_result;

            $user = User::where('id', $data['id'])->first();

            $user->delete();

            return true;
        } catch (Exception $ex) {
            $this->log('error', $ex->getMessage() . PHP_EOL . PHP_EOL . $ex->getTraceAsString());
            return false;
        }
    }
}
