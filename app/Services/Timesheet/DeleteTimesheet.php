<?php

namespace App\Services\Timesheet;

use App\Services\BaseService;
use App\Models\Timesheet;
use Exception;

class DeleteTimesheet extends BaseService
{
    /**
     * validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:timesheets,id',
        ];
    }

    /**
     * Update a Timesheet.
     *
     * @param array $data
     * @return mixed
     */
    public function execute(array $data)
    {
        try {
            $validated_result = $this->validate($data);
            if ($validated_result !== true) return $validated_result;

            $timesheet = Timesheet::where('id', $data['id'])->first();

            $timesheet->delete();

            return true;
        } catch (Exception $ex) {
            $this->log('error', $ex->getMessage() . PHP_EOL . PHP_EOL . $ex->getTraceAsString());
            return false;
        }
    }
}
