<?php

namespace Tests\Unit;

use App\Exceptions\UserNotAllowedToCreateAccount;
use App\Models\Account;
use App\Models\User;
use App\Services\AccountService;
use App\Services\UserService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function testAccountServiceMake()
    {
        $accountService = $this->app->make(AccountService::class);
        $this->assertInstanceOf(AccountService::class, $accountService);

        return $accountService;
    }

    /**
     * test create account.
     * @depends testAccountServiceMake
     * @param AccountService $accountService
     * @return void
     * @throws \App\Exceptions\GeneralError
     * @throws \App\Exceptions\UserNotAllowedToCreateAccount
     */
    public function testCreateAccount(AccountService $accountService)
    {
        /** @var User $user */
        $user = factory(\App\Models\User::class)->states("enough_salary")->create();
        $accountData = factory(Account::class)->raw();
        $account = $accountService->createAccount($user->id, $accountData);
        $this->assertTrue(Str::startsWith($account->id, \App\Models\Account::idPrefix()));
    }

    /**
     * test create account denied for not enough salary.
     * @depends testAccountServiceMake
     * @param AccountService $accountService
     * @return void
     * @throws \App\Exceptions\GeneralError
     * @throws \App\Exceptions\UserNotAllowedToCreateAccount
     */
    public function testCreateAccountDeniedForNotEnoughSalary(AccountService $accountService)
    {
        $this->expectException(UserNotAllowedToCreateAccount::class);
        /** @var User $user */
        $user = factory(\App\Models\User::class)->states("not_enough_salary")->create();
        $accountData = factory(Account::class)->raw();
        $account = $accountService->createAccount($user->id, $accountData);
    }

    /**
     * test create account denied for already has one account.
     * @depends testAccountServiceMake
     * @param AccountService $accountService
     * @return void
     * @throws \App\Exceptions\GeneralError
     * @throws \App\Exceptions\UserNotAllowedToCreateAccount
     */
    public function testCreateAccountDeniedForAlreadyHasAccount(AccountService $accountService)
    {
        $this->expectException(UserNotAllowedToCreateAccount::class);
        /** @var User $user */
        $user = factory(\App\Models\User::class)->states("enough_salary")->create();
        $accountData = factory(Account::class)->raw();

        $accountService->createAccount($user->id, $accountData);
        $accountService->createAccount($user->id, $accountData);
    }

    /**
     * test list accounts.
     * @depends testAccountServiceMake
     * @param AccountService $accountService
     * @return void
     * @throws \App\Exceptions\GeneralError
     * @throws \App\Exceptions\UserNotAllowedToCreateAccount
     */
    public function testListAccounts(AccountService $accountService)
    {
        factory(\App\Models\User::class, 50)->states("enough_salary")->create()
            ->each(function (\App\Models\User $user) {
                $user->accounts()->save(factory(\App\Models\Account::class)->make());
            });

        $accounts = $accountService->listAccounts();

        $this->assertInstanceOf(Paginator::class, $accounts);
        $this->assertInstanceOf(Account::class, $accounts->items()[0]);
        $this->assertEquals(50, $accounts->total());
    }

    /**
     * test list accounts of user.
     * @depends testAccountServiceMake
     * @param AccountService $accountService
     * @return void
     * @throws \App\Exceptions\GeneralError
     * @throws \App\Exceptions\UserNotAllowedToCreateAccount
     */
    public function testListAccountsOfUser(AccountService $accountService)
    {
        /** @var User $user */
        $user = factory(\App\Models\User::class)->states("enough_salary")->create();
        $user->accounts()->save(factory(\App\Models\Account::class)->make());

        $accounts = $accountService->listAccountsOfUser($user->id);

        $this->assertInstanceOf(Collection::class, $accounts);
        $this->assertInstanceOf(Account::class, $accounts[0]);
        $this->assertCount(1, $accounts);
    }

}
