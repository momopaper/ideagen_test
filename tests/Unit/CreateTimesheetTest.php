<?php

namespace Tests\Unit;

use App\Models\Timesheet;
use App\Models\User;
use App\Services\Timesheet\CreateTimesheet;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateTimesheetTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Create timesheet test.
     */
    public function test_create_timesheet(): void
    {
        $user = User::factory()->create();

        $data = [
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'task information',
            'user_id' => $user->id,
        ];
        $response = app(CreateTimesheet::class)->execute($data);
        $this->assertInstanceOf(Timesheet::class, $response);
        $this->assertDatabaseHas('timesheets', ['id' => $response->id]);
    }
}
