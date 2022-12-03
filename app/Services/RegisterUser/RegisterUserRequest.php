<?php

namespace App\Services\RegisterUser;

class RegisterUserRequest
{
    private string $name;
    private string $email;
    private string $unhashed_password;
    private string $alamat;

    /**
     * @param string $name
     * @param string $email
     * @param string $unhashed_password
     * @param string $alamat
     */
    public function __construct(string $name, string $email, string $unhashed_password, string $alamat)
    {
        $this->name = $name;
        $this->email = $email;
        $this->unhashed_password = $unhashed_password;
        $this->alamat = $alamat;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
    public function getUnhashedPassword(): string
    {
        return $this->unhashed_password;
    }

    /**
     * @return string
     */
    public function getAlamat(): string
    {
        return $this->alamat;
    }

}
