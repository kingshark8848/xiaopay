<?php


namespace App\Exceptions;

abstract class AbstractXiaoPayApiError extends \Exception
{
    abstract public function getErrorCode(): string ;

    abstract public function getErrorMessage(): string ;

    abstract public function getHttpStatusCode(): int ;

    public function genResponseData(): array
    {
        return [
            "error_code"=>$this->getErrorCode(),
            "error_message"=>$this->getErrorMessage()
        ];
    }

    public function renderJsonResponse()
    {
        return response()->json($this->genResponseData(), $this->getHttpStatusCode());
    }
}
