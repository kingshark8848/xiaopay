<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test user create - ok
     *
     * @return void
     */
    public function testUserCreate()
    {
        $response = $this->post('/api/v1/users', [
            "email" => "kingshark5@gmail.com",
            "name" => "kingshark5",
            "month_salary" => 5000.44,
            "month_expense" => 1001
        ]);
        $response->assertStatus(201);
    }

    /**
     * test user create - validation error
     *
     * @return void
     */
    public function testUserCreateValidationError()
    {
        $response = $this->post('/api/v1/users', [
            "email" => "kingshark1@gmail.com",
        ]);
        $response->assertStatus(422);
    }

    /**
     * test user create - cannot create more than one user using same email
     *
     * @return void
     */
    public function testOneEmailCannotCreateMultipleUsers()
    {
        $response = $this->post('/api/v1/users', [
            "email" => "kingshark5@gmail.com",
            "name" => "kingshark5",
            "month_salary" => 5000.44,
            "month_expense" => 1001
        ]);
        $response->assertStatus(201);

        $response = $this->post('/api/v1/users', [
            "email" => "kingshark5@gmail.com",
            "name" => "kingshark5",
            "month_salary" => 5000.44,
            "month_expense" => 1001
        ]);
        $response->assertStatus(422);
    }

    /**
     * test list users - ok
     *
     * @return void
     */
    public function testListUsersOk()
    {
        factory(\App\Models\User::class,50)->states("enough_salary")->create();
        factory(\App\Models\User::class,50)->states("not_enough_salary")->create();

        $response = $this->get('/api/v1/users');
        $response->assertStatus(200);
    }

    /**
     * test show user - ok
     *
     * @return void
     */
    public function testShowUserOk()
    {
        
        $user = factory(\App\Models\User::class)->states("enough_salary")->create();
        $response = $this->get('/api/v1/users/'.($user->id?:"dummy"));
        $response->assertStatus(200);
    }
}
