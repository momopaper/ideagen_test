<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\User\CreateUser;
use App\Services\User\DeleteUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class DeleteUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic unit test example.
     */
    public function test_delete_user(): void
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

        $data = [
            'id' => $user->id,
        ];
        $response = app(DeleteUser::class)->execute($data);
        $this->assertEquals(true, $response);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }
}
