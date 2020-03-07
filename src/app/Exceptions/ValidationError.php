<?php


namespace App\Exceptions;


class ValidationError extends AbstractXiaoPayApiError
{
    protected $errors = [];

    /**
     * @param array $errors
     * @return ValidationError
     */
    public function setErrors(array $errors): ValidationError
    {
        $this->errors = $errors;
        return $this;
    }

    public function getErrorCode(): string
    {
        return ErrorsLib::CODE__VALIDATION_ERROR;
    }

    public function getErrorMessage(): string
    {
        return "The given data was invalid.";
    }

    public function getHttpStatusCode(): int
    {
        return 422;
    }

    public function genResponseData(): array
    {
        $data = parent::genResponseData();
        $data["validation_errors"] = $this->errors;
        return $data;
    }
}
