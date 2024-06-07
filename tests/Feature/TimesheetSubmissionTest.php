<?php

namespace Tests\Feature;

use App\Models\Timesheet;
use App\Models\User;
use App\Services\Timesheet\CreateTimesheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TimesheetSubmissionTest extends TestCase
{
    public function test_can_view_timesheet_list(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/timesheet');

        $response->assertStatus(200);
    }

    public function test_can_add_timesheet(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/timesheet/store', [
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'task information',
            'user_id' => $user->id,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/timesheet');
    }

    public function test_can_view_timesheet(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'task information',
            'user_id' => $user->id,
        ];
        $timesheet = app(CreateTimesheet::class)->execute($data);
        $this->assertInstanceOf(Timesheet::class, $timesheet);

        $response = $this->get('/timesheet/' . $timesheet->id);

        $response->assertStatus(200);
    }

    public function test_can_update_timesheet(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'task information',
            'user_id' => $user->id,
        ];
        $timesheet = app(CreateTimesheet::class)->execute($data);
        $this->assertInstanceOf(Timesheet::class, $timesheet);

        $response = $this->post('/timesheet/' . $timesheet->id . '/update', [
            'id' => $timesheet->id,
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'update task information',
        ]);

        $response->assertStatus(302);
        $this->assertEquals('update task information', $timesheet->fresh()->task_information);
        $this->assertEquals(false, $timesheet->fresh()->is_approved);
        $response->assertRedirect('/timesheet');
    }

    public function test_diff_user_cant_update_timesheet(): void
    {
        $another_user = User::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'task information',
            'user_id' => $another_user->id,
        ];
        $timesheet = app(CreateTimesheet::class)->execute($data);
        $this->assertInstanceOf(Timesheet::class, $timesheet);

        $response = $this->post('/timesheet/' . $timesheet->id . '/update', [
            'id' => $timesheet->id,
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'update task information',
        ]);

        $response->assertStatus(403);
    }

    public function test_can_delete_timesheet(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'task information',
            'user_id' => $user->id,
        ];
        $timesheet = app(CreateTimesheet::class)->execute($data);
        $this->assertInstanceOf(Timesheet::class, $timesheet);

        $response = $this->post('/timesheet/' . $timesheet->id . '/remove', [
            'id' => $timesheet->id,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/timesheet');
    }

    public function test_diff_user_cant_delete_timesheet(): void
    {
        $another_user = User::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'task information',
            'user_id' => $another_user->id,
        ];
        $timesheet = app(CreateTimesheet::class)->execute($data);
        $this->assertInstanceOf(Timesheet::class, $timesheet);

        $response = $this->post('/timesheet/' . $timesheet->id . '/remove', [
            'id' => $timesheet->id,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_approve_timesheet(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $data = [
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'task information',
            'user_id' => $user->id,
        ];
        $timesheet = app(CreateTimesheet::class)->execute($data);
        $this->assertInstanceOf(Timesheet::class, $timesheet);

        $response = $this->post('/timesheet/' . $timesheet->id . '/approve', [
            'id' => $timesheet->id,
        ]);

        $response->assertStatus(302);
        $this->assertEquals(true, $timesheet->fresh()->is_approved);
        $response->assertRedirect('/timesheet');
    }

    public function test_user_cant_approve_timesheet(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
            'time_out' => date('H:i:s', strtotime("+30 minutes")),
            'task_information' => 'task information',
            'user_id' => $user->id,
        ];
        $timesheet = app(CreateTimesheet::class)->execute($data);
        $this->assertInstanceOf(Timesheet::class, $timesheet);

        $response = $this->post('/timesheet/' . $timesheet->id . '/approve', [
            'id' => $timesheet->id,
        ]);

        $response->assertStatus(403);
    }
}
