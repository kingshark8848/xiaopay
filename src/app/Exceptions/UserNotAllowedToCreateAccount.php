<?php


namespace App\Exceptions;


class UserNotAllowedToCreateAccount extends AbstractXiaoPayApiError
{
    public function getErrorCode(): string
    {
        return ErrorsLib::CODE__USER_NOT_ALLOWED_TO_CREATE_ACCOUNT;
    }

    public function getErrorMessage(): string
    {
        return $this->getMessage();
    }

    public function getHttpStatusCode(): int
    {
        return 400;
    }
}
