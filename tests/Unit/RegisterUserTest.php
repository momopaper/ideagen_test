<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\User\RegisterUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Register User test.
     */
    public function test_register_user(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'TestUser@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'ic' => 'IC123',
            'epf_no' => 'EPF123',
            'socso_no' => 'SOCSO123',
            'employee_no' => 'EMPLOYEE123'
        ];
        $response = app(RegisterUser::class)->execute($data);
        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals($response->hasRole('user'), true);
        $this->assertDatabaseHas('users', ['id' => $response->id]);
    }
}
