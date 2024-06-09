<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\User\CreateUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_admin_can_view_user_list(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $response = $this->get('/user');

        $response->assertStatus(200);
    }

    public function test_user_cant_view_user_list(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $response = $this->get('/user');

        $response->assertStatus(401);
    }

    public function test_admin_can_add_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $response = $this->post('/user/store', [
            'name' => 'Test User Name',
            'email' => 'test@test.com',
            'password' => 'password',
            'ic' => '12345',
            'epf_no' => 'EPFNO',
            'socso_no' => 'SOCSONO',
            'employee_no' => 'EMPLOYEENO',
            'role' => 'user'
        ]);

        $response->assertStatus(200);
        $this->assertEquals(true, json_decode($response->getContent(), true)['success']);
        $this->assertDatabaseHas('users', ['id' => json_decode($response->getContent(), true)['result']['id']]);
    }

    public function test_user_cant_add_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $response = $this->post('/user/store', [
            'name' => 'Test User Name',
            'email' => 'test@test.com',
            'password' => 'password',
            'ic' => '12345',
            'epf_no' => 'EPFNO',
            'socso_no' => 'SOCSONO',
            'employee_no' => 'EMPLOYEENO',
            'role' => 'user'
        ]);

        $response->assertStatus(401);
    }


    public function test_admin_can_view_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $data = [
            'name' => 'Test User',
            'email' => 'TestUser@test.com',
            'password' => 'password',
            'ic' => 'IC123',
            'epf_no' => 'EPF123',
            'socso_no' => 'SOCSO123',
            'employee_no' => 'EMPLOYEE123',
            'role' => 'user'
        ];
        $_user = app(CreateUser::class)->execute($data);
        $this->assertInstanceOf(User::class, $_user);

        $response = $this->get('/user/' . $_user->id);
        $response->assertStatus(200);
    }

    public function test_user_cant_view_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $data = [
            'name' => 'Test User',
            'email' => 'TestUser@test.com',
            'password' => 'password',
            'ic' => 'IC123',
            'epf_no' => 'EPF123',
            'socso_no' => 'SOCSO123',
            'employee_no' => 'EMPLOYEE123',
            'role' => 'user'
        ];
        $_user = app(CreateUser::class)->execute($data);
        $this->assertInstanceOf(User::class, $_user);

        $response = $this->get('/user/' . $_user->id);
        $response->assertStatus(401);
    }

    public function test_admin_can_update_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $data = [
            'name' => 'Test User',
            'email' => 'TestUser@test.com',
            'password' => 'password',
            'ic' => 'IC123',
            'epf_no' => 'EPF123',
            'socso_no' => 'SOCSO123',
            'employee_no' => 'EMPLOYEE123',
            'role' => 'user'
        ];
        $_user = app(CreateUser::class)->execute($data);
        $this->assertInstanceOf(User::class, $_user);

        $response = $this->post('/user/' . $_user->id . '/update', [
            'id' => $_user->id,
            'name' => 'Updated Test User',
            'email' => 'UpdatedTestUser@test.com',
            'ic' => 'UpdatedIC123',
            'epf_no' => 'UpdatedEPF123',
            'socso_no' => 'UpdatedSOCSO123',
            'employee_no' => 'UpdatedEMPLOYEE123',
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Updated Test User', $_user->fresh()->name);
        $this->assertEquals(true, json_decode($response->getContent(), true)['success']);
    }

    public function test_user_cant_update_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $data = [
            'name' => 'Test User',
            'email' => 'TestUser@test.com',
            'password' => 'password',
            'ic' => 'IC123',
            'epf_no' => 'EPF123',
            'socso_no' => 'SOCSO123',
            'employee_no' => 'EMPLOYEE123',
            'role' => 'user'
        ];
        $_user = app(CreateUser::class)->execute($data);
        $this->assertInstanceOf(User::class, $_user);

        $response = $this->post('/user/' . $user->id . '/update', [
            'id' => $user->id,
            'name' => 'Updated Test User',
            'email' => 'UpdatedTestUser@test.com',
            'ic' => 'UpdatedIC123',
            'epf_no' => 'UpdatedEPF123',
            'socso_no' => 'UpdatedSOCSO123',
            'employee_no' => 'UpdatedEMPLOYEE123',
        ]);

        $response->assertStatus(401);
    }

    public function test_admin_can_delete_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $data = [
            'name' => 'Test User',
            'email' => 'TestUser@test.com',
            'password' => 'password',
            'ic' => 'IC123',
            'epf_no' => 'EPF123',
            'socso_no' => 'SOCSO123',
            'employee_no' => 'EMPLOYEE123',
            'role' => 'user'
        ];
        $_user = app(CreateUser::class)->execute($data);
        $this->assertInstanceOf(User::class, $_user);

        $response = $this->post('/user/' . $_user->id . '/remove', [
            'id' => $_user->id,
        ]);

        $response->assertStatus(200);
        $this->assertSoftDeleted('users', ['id' => $_user->id]);
        $this->assertEquals(true, json_decode($response->getContent(), true)['success']);
    }

    public function test_user_cant_delete_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $data = [
            'name' => 'Test User',
            'email' => 'TestUser@test.com',
            'password' => 'password',
            'ic' => 'IC123',
            'epf_no' => 'EPF123',
            'socso_no' => 'SOCSO123',
            'employee_no' => 'EMPLOYEE123',
            'role' => 'user'
        ];
        $_user = app(CreateUser::class)->execute($data);
        $this->assertInstanceOf(User::class, $_user);

        $response = $this->post('/user/' . $_user->id . '/remove', [
            'id' => $_user->id,
        ]);

        $response->assertStatus(401);
    }
}
