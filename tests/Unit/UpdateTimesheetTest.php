<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Timesheet\CreateTimesheet;
use App\Services\Timesheet\UpdateTimesheet;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateTimesheetTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Update timesheet test.
     */
    public function test_update_timesheet(): void
    {
        $user = User::factory()->create();

        $data = [
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'task information',
            'user_id' => $user->id,
        ];
        $timesheet = app(CreateTimesheet::class)->execute($data);


        $time_in = date('H:i:s', strtotime("+30 minutes"));
        $time_out = date('H:i:s', strtotime("+60 minutes"));

        $data = [
            'id' => $timesheet->id,
            'date' => date('Y-m-d'),
            'time_in' => $time_in,
            'time_out' => $time_out,
            'task_information' => 'update task information',
        ];
        $response = app(UpdateTimesheet::class)->execute($data);
        $this->assertEquals(true, $response);
        $this->assertEquals('update task information', $timesheet->fresh()->task_information);
    }
}
