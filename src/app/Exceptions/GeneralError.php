<?php


namespace App\Exceptions;


use Throwable;

class GeneralError extends AbstractXiaoPayApiError
{
    /**
     * @var null
     */
    private $errorCode;

    /**
     * @var int
     */
    private $httpStatusCode;

    public function __construct($errorMessage = "", $errorCode = null, $httpStatusCode = 500, Throwable $previous = null)
    {
        parent::__construct($errorMessage, 0, $previous);
        $this->errorCode = $errorCode?:ErrorsLib::CODE__ERROR;
        $this->httpStatusCode = $httpStatusCode?:500;
    }


    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getErrorMessage(): string
    {
        return $this->message;
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }
}
