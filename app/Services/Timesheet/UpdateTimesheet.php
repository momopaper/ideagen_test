<?php

namespace App\Services\Timesheet;

use App\Services\BaseService;
use App\Models\Timesheet;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateTimesheet extends BaseService
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
            'date' => 'required|date|date_format:Y-m-d',
            'time_in' => 'required|date_format:H:i:s',
            'time_out' => 'required|date_format:H:i:s|after:time_in',
            'task_information' => 'required|string',
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

            $timesheet->update([
                'date' => $data['date'],
                'time_in' => $data['time_in'],
                'time_out' => $data['time_out'],
                'task_information' => $data['task_information'],
                'is_approved' => false,
                'approved_at' => null
            ]);

            return true;
        } catch (Exception $ex) {
            $this->log('error', $ex->getMessage() . PHP_EOL . PHP_EOL . $ex->getTraceAsString());
            return false;
        }
    }
}
