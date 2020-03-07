<?php


namespace App\Services;


use App\Exceptions\ErrorsLib;
use App\Exceptions\GeneralError;
use App\Exceptions\UserNotAllowedToCreateAccount;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountService
{
    /**
     * @param $userId
     * @return User
     * @throws GeneralError
     */
    protected function _fetchUserById($userId)
    {
        try {
            /** @var User $user */
            $user = User::query()->findOrFail($userId);
        } catch (ModelNotFoundException $e) {
            throw new GeneralError("user[$userId] not found",
                ErrorsLib::CODE_USER_NOT_FOUND, 400);
        }

        return $user;
    }

    /**
     * @param $userId
     * @param $data
     * @return Account
     * @throws GeneralError
     * @throws UserNotAllowedToCreateAccount
     */
    public function createAccount($userId, $data)
    {
        $user = $this->_fetchUserById($userId);

        $this->_checkUserAllowedToCreateAccount($user);

        try {
            /** @var Account $account */
            $account = $user->accounts()->create($data);
        } catch (\Exception $e) {
            throw new GeneralError("account create error",
                ErrorsLib::CODE_ACCOUNT_CREATE_ERROR,
                500);
        }

        return $account;
    }

    /**
     * @param User $user
     * @throws UserNotAllowedToCreateAccount
     */
    protected function _checkUserAllowedToCreateAccount(User $user)
    {
        if( ($user->month_salary - $user->month_expense) < 1000 ){
            throw new UserNotAllowedToCreateAccount("cannot open account for user:"
            ." monthly salary and monthly expense not meet requirement");
        }

        if ($user->accounts()->count()>=1){
            throw new UserNotAllowedToCreateAccount("cannot open account for user:"
            ." an user can only create a single account now");
        }
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws GeneralError
     */
    public function listAccounts()
    {
        try {
            return Account::query()->paginate();
        } catch (\Exception $e) {
            throw new GeneralError("list accounts error", null, 500);
        }
    }

    /**
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws GeneralError
     */
    public function listAccountsOfUser($userId)
    {
        $user = $this->_fetchUserById($userId);

        try {
            return $user->accounts()->get();
        } catch (\Exception $e) {
            throw new GeneralError("list user[$userId] accounts error", null, 500);
        }
    }
}
