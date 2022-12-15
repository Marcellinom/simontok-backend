<?php

namespace App\Services\CreateProduct;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateProductRequest
{
    private int $shop_id;
    private string $name;
    private float $unit_price;
    private array $categories_id;
    private ?UploadedFile $image;

    /**
     * @param int $shop_id
     * @param string $name
     * @param float $unit_price
     * @param array $categories_id
     * @param UploadedFile|null $image
     */
    public function __construct(int $shop_id, string $name, float $unit_price, array $categories_id, ?UploadedFile $image)
    {
        $this->shop_id = $shop_id;
        $this->name = $name;
        $this->unit_price = $unit_price;
        $this->categories_id = $categories_id;
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getShopId(): int
    {
        return $this->shop_id;
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
     * @return array
     */
    public function getCategoriesId(): array
    {
        return $this->categories_id;
    }

    /**
     * @return UploadedFile|null
     */
    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }
}
