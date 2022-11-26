<?php

namespace App\Models\Shared;

use App\Exceptions\ExpectedException;
use Exception;
use Validator;

class Email
{
    private string $email;

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @throws Exception
     */
    public static function validate(string $email): self
    {
        if (Validator::make(['email' => $email], [
            'email' => 'email|required'
        ])->fails()) ExpectedException::throw("invalid email format", 1020);

        return (new self($email));
    }
}
