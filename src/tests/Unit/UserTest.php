<?php

namespace Tests\Unit;

use App\Exceptions\GeneralError;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserServiceMake()
    {
        $userService = $this->app->make(UserService::class);
        $this->assertInstanceOf(UserService::class, $userService);

        return $userService;
    }

    /**
     * test create user.
     * @depends testUserServiceMake
     * @param UserService $userService
     * @return void
     * @throws \App\Exceptions\GeneralError
     */
    public function testCreateUser(UserService $userService)
    {
        $data = factory(\App\Models\User::class)->states("enough_salary")->raw();
        $user = $userService->createUser($data);
        $this->assertTrue(Str::startsWith($user->id, \App\Models\User::idPrefix()));
    }

    /**
     * test list users.
     * @depends testUserServiceMake
     * @param UserService $userService
     * @return void
     * @throws \App\Exceptions\GeneralError
     */
    public function testListUsers(UserService $userService)
    {
        factory(\App\Models\User::class,50)->states("enough_salary")->create();
        factory(\App\Models\User::class,50)->states("not_enough_salary")->create();

        $users = $userService->listUsers();

        $this->assertInstanceOf(Paginator::class, $users);
        $this->assertInstanceOf(User::class, $users->items()[0]);
        $this->assertEquals(100, $users->total());
    }

    /**
     * test show users.
     * @depends testUserServiceMake
     * @param UserService $userService
     * @return void
     * @throws \App\Exceptions\GeneralError
     */
    public function testShowUser(UserService $userService)
    {
        $data = factory(\App\Models\User::class)->states("enough_salary")->raw();
        $user = $userService->createUser($data);

        $user = $userService->showUser($user->id);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * test show users but not found.
     * @depends testUserServiceMake
     * @param UserService $userService
     * @return void
     * @throws \App\Exceptions\GeneralError
     */
    public function testShowUserNotFound(UserService $userService)
    {
        $userId = "not_exists";
        $this->expectException(GeneralError::class);
        $this->expectErrorMessage("user[$userId] not found");

        $userService->showUser($userId);
    }
}
