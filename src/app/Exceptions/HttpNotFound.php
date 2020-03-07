<?php


namespace App\Exceptions;


use Illuminate\Http\JsonResponse;

class HttpNotFound extends AbstractXiaoPayApiError
{
    public function getErrorCode(): string
    {
        return ErrorsLib::CODE__HTTP_NOT_FOUND;
    }

    public function getErrorMessage(): string
    {
        return "http not found";
    }

    public function getHttpStatusCode(): int
    {
        return 404;
    }

}
