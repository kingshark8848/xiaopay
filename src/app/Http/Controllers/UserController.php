<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @param Request $request
     * @return UserResource
     * @throws \Illuminate\Validation\ValidationException
     * @throws \App\Exceptions\GeneralError
     */
    public function create(Request $request)
    {
        $this->validate($request,[
            "email" => "required|unique:users,email",
            "name" => "required",
            "month_salary" => "required|numeric|gt:0",
            "month_expense" => "required|numeric|gt:0",
        ]);

        $user = $this->userService->createUser($request->only([
            "email", "name", "month_salary", "month_expense"
        ]));

        return new UserResource($user);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \App\Exceptions\GeneralError
     */
    public function list(Request $request)
    {
        $users = $this->userService->listUsers();
        return UserResource::collection($users);
    }

    /**
     * @param Request $request
     * @param $userId
     * @return UserResource
     * @throws \App\Exceptions\GeneralError
     */
    public function show(Request $request, $userId)
    {
        $user = $this->userService->showUser($userId);
        return new UserResource($user);
    }
}
