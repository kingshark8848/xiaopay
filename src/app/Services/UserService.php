<?php


namespace App\Services;


use App\Exceptions\ErrorsLib;
use App\Exceptions\GeneralError;
use App\Models\User;

class UserService
{
    /**
     * @param $data
     * @return User
     * @throws GeneralError
     */
    public function createUser($data)
    {
        try {
            return tap((new User())->fill($data))->save();
        } catch (\Exception $e) {
            throw new GeneralError("user create error", ErrorsLib::CODE_USER_CREATE_ERROR,
                500);
        }
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws GeneralError
     */
    public function listUsers()
    {
        try {
            return User::query()->paginate();
        } catch (\Exception $e) {
            throw new GeneralError("list users error", null, 500);
        }
    }

    /**
     * @param $userId
     * @return User
     * @throws GeneralError
     */
    public function showUser($userId)
    {
        /** @var User $user */
        try {
            $user = User::query()->findOrFail($userId);
        } catch (\Exception $e) {
            throw new GeneralError("user[$userId] not found", ErrorsLib::CODE_USER_NOT_FOUND,
                404);
        }

        return $user;
    }
}
