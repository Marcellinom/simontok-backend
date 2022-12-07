<?php

namespace App\Services\EditUser;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class EditUserRequest
{
    private ?string $name;
    private ?string $new_password;
    private ?UploadedFile $image;

    /**
     * @param string|null $name
     * @param string|null $new_password
     * @param UploadedFile|null $image
     */
    public function __construct(?string $name, ?string $new_password, ?UploadedFile $image)
    {
        $this->name = $name;
        $this->new_password = $new_password;
        $this->image = $image;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getNewPassword(): ?string
    {
        return $this->new_password;
    }

    /**
     * @return UploadedFile|null
     */
    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }
}
