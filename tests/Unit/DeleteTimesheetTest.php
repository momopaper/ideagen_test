<?php

namespace Tests\Unit;

use App\Models\Timesheet;
use App\Models\User;
use App\Services\Timesheet\CreateTimesheet;
use App\Services\Timesheet\DeleteTimesheet;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteTimesheetTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Delete timesheet test.
     */
    public function test_delete_timesheet(): void
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
        $response = app(DeleteTimesheet::class)->execute($data);
        $this->assertEquals(true, $response);
        $this->assertSoftDeleted('timesheets', ['id' => $timesheet->id]);
    }
}
