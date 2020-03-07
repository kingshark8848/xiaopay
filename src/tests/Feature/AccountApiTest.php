<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Account;
use App\Models\User;

class AccountApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test account create - ok
     *
     * @return void
     */
    public function testAccountCreateOk()
    {
        $user = factory(\App\Models\User::class)->states("enough_salary")->create();
        $userId = $user->id ?: "dummy";

        $response = $this->post("/api/v1/users/{$userId}/accounts", [
            "first_name" => "Shawn",
            "last_name" => "Pug",
            "address" => "NSW",
            "gender" => \App\Models\Account::GENDER__MALE,
            "date_of_birth" => "2012-12-11",
        ]);
        $response->assertStatus(201);
    }

    /**
     * user without enough salary-expense cannot create account
     *
     * @return void
     */
    public function testUserWithoutEnoughSalaryVsExpenseCannotCreateAccount()
    {
        $user = factory(\App\Models\User::class)->states("not_enough_salary")->create();
        $userId = $user->id ?: "dummy";

        $response = $this->post("/api/v1/users/{$userId}/accounts", [
            "first_name" => "Shawn",
            "last_name" => "Pug",
            "address" => "NSW",
            "gender" => \App\Models\Account::GENDER__MALE,
            "date_of_birth" => "2012-12-11",
        ]);
        $response->assertStatus(400);
    }

    /**
     * user cannot create multiple accounts
     *
     * @return void
     */
    public function testUserCannotCreateMultipleAccounts()
    {
        $user = factory(\App\Models\User::class)->states("enough_salary")->create();
        $userId = $user->id ?: "dummy";

        $response = $this->post("/api/v1/users/{$userId}/accounts", [
            "first_name" => "Shawn",
            "last_name" => "Pug",
            "address" => "NSW",
            "gender" => \App\Models\Account::GENDER__MALE,
            "date_of_birth" => "2012-12-11",
        ]);
        $response->assertStatus(201);

        $response = $this->post("/api/v1/users/{$userId}/accounts", [
            "first_name" => "Shawn2",
            "last_name" => "Pug2",
            "address" => "NSW",
            "gender" => \App\Models\Account::GENDER__MALE,
            "date_of_birth" => "2012-12-11",
        ]);
        $response->assertStatus(400);
    }

    /**
     * user cannot create accounts without first_name
     *
     * @return void
     */
    public function testUserCannotCreateAccountWithoutFirstname()
    {
        $user = factory(\App\Models\User::class)->states("enough_salary")->create();
        $userId = $user->id ?: "dummy";

        $response = $this->post("/api/v1/users/{$userId}/accounts", [
            "last_name" => "Pug",
            "address" => "NSW",
            "gender" => \App\Models\Account::GENDER__MALE,
            "date_of_birth" => "2012-12-11",
        ]);
        $response->assertStatus(422);
    }

    /**
     * list accounts ok
     *
     * @return void
     */
    public function testListAccountsOk()
    {
        factory(\App\Models\User::class, 50)->states("enough_salary")->create()
            ->each(function (\App\Models\User $user) {
                $user->accounts()->save(factory(\App\Models\Account::class)->make());
            });

        $response = $this->get("/api/v1/accounts?page=2");
        $response->assertStatus(200);
    }

    /**
     * list accounts of user ok
     *
     * @return void
     */
    public function testListAccountsOfUserOk()
    {
        /** @var User $user */
        $user = factory(\App\Models\User::class)->states("enough_salary")->create();
        $user->accounts()->save(factory(\App\Models\Account::class)->make());
        $userId = $user->id;

        $response = $this->get("/api/v1/users/{$userId}/accounts");
        $response->assertStatus(200);
    }
}
