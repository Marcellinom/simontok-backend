<?php

namespace App\Services\CreateProduct;

class CreateProductRequest
{
    private int $marketplace_id;
    private string $name;
    private float $unit_price;

    /**
     * @param int $marketplace_id
     * @param string $name
     * @param float $unit_price
     */
    public function __construct(int $marketplace_id, string $name, float $unit_price)
    {
        $this->marketplace_id = $marketplace_id;
        $this->name = $name;
        $this->unit_price = $unit_price;
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
}
