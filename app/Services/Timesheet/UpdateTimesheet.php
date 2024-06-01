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
            'timesheet_id' => 'required|integer|exists:timesheets,id',
            'date' => 'required|date|date_format:Y-m-d',
            'time_in' => 'required|date|date_format:Hi',
            'time_out' => 'required|date|date_format:Hi|after:time_in',
            'task_information' => 'required|string',
        ];
    }

    /**
     * Update a Timesheet.
     *
     * @param array $data
     * @return boolean
     */
    public function execute(array $data): bool
    {
        try {
            $this->validate($data);

            $timesheet = Timesheet::where('id', $data['timesheet_id'])->first();

            DB::beginTransaction();
            $timesheet->update([
                'date' => $data['date'],
                'time_in' => $data['time_in'],
                'time_out' => $data['time_out'],
                'task_information' => $data['task_information'],
                'is_approved' => false,
                'approved_at' => null
            ]);
            DB::commit();

            return true;
        } catch (Exception $ex) {
            $this->log('error', $ex->getMessage() . PHP_EOL . PHP_EOL . $ex->getTraceAsString());
            DB::rollBack();
            return false;
        }
    }
}
