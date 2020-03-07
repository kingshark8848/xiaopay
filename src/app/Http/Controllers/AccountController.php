<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * @var AccountService
     */
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @param Request $request
     * @param $userId
     * @return AccountResource
     * @throws \App\Exceptions\GeneralError
     * @throws \App\Exceptions\UserNotAllowedToCreateAccount
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request, $userId)
    {
        $this->validate($request,[
            "first_name" => "required",
            "last_name" => "required",
            "address" => "required",
            "gender" => ["sometimes", Rule::in(Account::allGenders())],
            "date_of_birth" => ["sometimes", "date_format:Y-m-d"],
        ]);

        $account = $this->accountService->createAccount($userId,
            $request->only(["first_name", "last_name", "address", "gender", "date_of_birth"]));

        return new AccountResource($account);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \App\Exceptions\GeneralError
     */
    public function list(Request $request)
    {
        $accounts = $this->accountService->listAccounts();

        return AccountResource::collection($accounts);
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \App\Exceptions\GeneralError
     */
    public function listOfUser(Request $request, $userId)
    {
        $accounts = $this->accountService->listAccountsOfUser($userId);

        return AccountResource::collection($accounts);
    }
}
