<?php

namespace Blackoin\ApiSdk\Exceptions;

use Exception;

class RequestException extends Exception
{
    private int $statusCode;
    private string $apiResponse;

    public function __construct(string $message, string $apiResponse, int $statusCode = 0)
    {
        parent::__construct($message);

        $this->apiResponse = $apiResponse;
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getApiResponse(): string
    {
        if ($this->apiResponse === "No balance") {
            return "Sua conta não possui saldo suficiente para transferir ao usuário.";
        }

        return $this->apiResponse;
    }
}
