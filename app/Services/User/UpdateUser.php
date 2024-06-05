<?php

namespace App\Services\User;

use App\Services\BaseService;
use App\Models\User;
use Exception;
use Illuminate\Validation\Rule;

class UpdateUser extends BaseService
{
    /**
     * validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $id = request()->input('id');

        return [
            'id' => 'required|integer|exists:users,id',
            'email' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->where(function ($query) use ($id) {
                    $query->whereNull('deleted_at')->where('id', '!=', $id);
                }),
            ],
            'name' => 'required|string|max:255',
            'epf_no' => 'required|string|max:255',
            'socso_no' => 'required|string|max:255',
            'employee_no' => 'required|string|max:255',
        ];
    }

    /**
     * Update an User.
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

            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'epf_no' => $data['epf_no'],
                'socso_no' => $data['socso_no'],
                'employee_no' => $data['employee_no']
            ]);

            return true;
        } catch (Exception $ex) {
            $this->log('error', $ex->getMessage() . PHP_EOL . PHP_EOL . $ex->getTraceAsString());
            return false;
        }
    }
}
