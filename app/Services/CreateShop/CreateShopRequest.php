<?php

namespace App\Services\CreateShop;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateShopRequest
{
    private string $name;
    private ?UploadedFile $image;

    /**
     * @param string $name
     * @param UploadedFile|null $image
     */
    public function __construct(string $name, ?UploadedFile $image)
    {
        $this->name = $name;
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return UploadedFile|null
     */
    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }
}
