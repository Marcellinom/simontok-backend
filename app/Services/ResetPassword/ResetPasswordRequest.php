<?php

namespace App\Services\ResetPassword;

class ResetPasswordRequest
{
    private string $email;
    private string $token;
    private string $new_password;

    /**
     * @param string $email
     * @param string $token
     * @param string $new_password
     */
    public function __construct(string $email, string $token, string $new_password)
    {
        $this->email = $email;
        $this->token = $token;
        $this->new_password = $new_password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->new_password;
    }
}
