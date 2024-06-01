<?php

namespace App\Services\Timesheet;

use App\Services\BaseService;
use App\Models\Timesheet;
use Exception;
use Illuminate\Support\Facades\DB;

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
            'timesheet_id' => 'required|integer|exists:timesheets,id',
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
            $timesheet->delete();;
            DB::commit();

            return true;
        } catch (Exception $ex) {
            $this->log('error', $ex->getMessage() . PHP_EOL . PHP_EOL . $ex->getTraceAsString());
            DB::rollBack();
            return false;
        }
    }
}
