<?php

namespace App\Services\Timesheet;

use App\Services\BaseService;
use App\Models\Timesheet;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateTimesheet extends BaseService
{

    /**
     * validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|date|date_format:Y-m-d',
            'time_in' => 'required|date|date_format:Hi',
            'time_out' => 'required|date|date_format:Hi|after:time_in',
            'task_information' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }

    /**
     * Create a Timesheet.
     *
     * @param array $data
     * @return Timesheet
     */
    public function execute(array $data): Timesheet
    {
        try {
            $this->validate($data);
            DB::beginTransaction();
            $timesheet = Timesheet::create([
                'date' => $data['date'],
                'time_in' => $data['time_in'],
                'time_out' => $data['time_out'],
                'task_information' => $data['task_information'],
                'is_approved' => false,
                'approved_at' => null,
                'user_id' => $data['user_id']
            ]);
            DB::commit();

            return $timesheet;
        } catch (Exception $ex) {
            $this->log('error', $ex->getMessage() . PHP_EOL . PHP_EOL . $ex->getTraceAsString());
            DB::rollBack();
            return false;
        }
    }
}
