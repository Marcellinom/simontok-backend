<?php

namespace App\Services\LoginUser;

use JsonSerializable;

class LoginUserResponse implements JsonSerializable
{
    private string $token;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token
        ];
    }
}
