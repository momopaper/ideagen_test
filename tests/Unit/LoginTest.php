<?php

namespace Tests\Unit;

use App\Services\Authentication\LoginUser;
use App\Services\User\CreateUser;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Login test.
     */
    public function test_login(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'TestUser1@test.com',
            'password' => 'password',
            'ic' => 'IC1231',
            'epf_no' => 'EPF123',
            'socso_no' => 'SOCSO123',
            'employee_no' => 'EMPLOYEE123',
            'role' => 'user'
        ];
        $user = app(CreateUser::class)->execute($data);

        $response = app(LoginUser::class)->execute([
            'email' => $user->email,
            'password' => 'password'
        ]);
        $this->assertEquals(true, $response);
    }
}
