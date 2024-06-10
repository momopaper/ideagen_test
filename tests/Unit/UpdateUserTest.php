<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\User\CreateUser;
use App\Services\User\UpdateUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Update User test.
     */
    public function test_update_user(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'TestUser2@test.com',
            'password' => 'password',
            'ic' => 'IC1232',
            'epf_no' => 'EPF123',
            'socso_no' => 'SOCSO123',
            'employee_no' => 'EMPLOYEE123',
            'role' => 'user'
        ];
        $user = app(CreateUser::class)->execute($data);

        $data = [
            'id' => $user->id,
            'name' => 'Update Test User',
            'email' => 'UpdateTestUser@test.com',
            'ic' => 'UpdateIC123',
            'epf_no' => 'UpdateEPF123',
            'socso_no' => 'UpdateSOCSO123',
            'employee_no' => 'UpdateEMPLOYEE123',
        ];
        $response = app(UpdateUser::class)->execute($data);
        $this->assertEquals(true, $response);
        $this->assertEquals('Update Test User', $user->fresh()->name);
    }
}
