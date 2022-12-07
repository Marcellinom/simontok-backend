<?php

namespace App\Services\CreateProduct;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateProductRequest
{
    private int $marketplace_id;
    private string $name;
    private float $unit_price;
    private string $category;
    private ?UploadedFile $image;

    /**
     * @param int $marketplace_id
     * @param string $name
     * @param float $unit_price
     * @param string $category
     * @param UploadedFile|null $image
     */
    public function __construct(int $marketplace_id, string $name, float $unit_price, string $category, ?UploadedFile $image)
    {
        $this->marketplace_id = $marketplace_id;
        $this->name = $name;
        $this->unit_price = $unit_price;
        $this->category = $category;
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getMarketplaceId(): int
    {
        return $this->marketplace_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return UploadedFile|null
     */
    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }
}
