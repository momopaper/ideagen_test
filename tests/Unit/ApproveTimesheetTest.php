<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Timesheet\ApproveTimesheet;
use App\Services\Timesheet\CreateTimesheet;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApproveTimesheetTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Approve timesheet test.
     */
    public function test_approve_timesheet(): void
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

        $data = [
            'id' => $timesheet->id,
        ];
        $response = app(ApproveTimesheet::class)->execute($data);
        $this->assertEquals(true, $response);
        $this->assertDatabaseHas('timesheets', ['id' => $timesheet->id, 'is_approved' => true]);
    }
}
