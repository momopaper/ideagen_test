<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\User\CreateUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Create User test.
     */
    public function test_create_user(): void
    {
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
        $response = app(CreateUser::class)->execute($data);
        $this->assertInstanceOf(User::class, $response);
        $this->assertDatabaseHas('users', ['id' => $response->id]);
    }
}
