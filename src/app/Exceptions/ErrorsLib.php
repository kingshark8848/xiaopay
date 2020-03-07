<?php


namespace App\Exceptions;


class ErrorsLib
{
    const CODE__ERROR = "error";
    const CODE__HTTP_NOT_FOUND = "http_not_found";
    const CODE__VALIDATION_ERROR = "request_data_validation_error";
    const CODE_USER_NOT_FOUND = "user_not_found";
    const CODE_USER_CREATE_ERROR = "user_create_error";
    const CODE__USER_NOT_ALLOWED_TO_CREATE_ACCOUNT = "user_not_allowed_to_create_account";
    const CODE_ACCOUNT_CREATE_ERROR = "account_create_error";
}
