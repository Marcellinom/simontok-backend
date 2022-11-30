<?php

namespace App\Services\EditProduct;

class EditProductRequest
{
    private int $product_id;
    private ?string $name;
    private ?float $unit_price;
    private ?AddProductMovementRequest $new_product_movement;

    /**
     * @param int $product_id
     * @param string|null $name
     * @param float|null $unit_price
     * @param AddProductMovementRequest|null $new_product_movement
     */
    public function __construct(int $product_id, ?string $name, ?float $unit_price, ?AddProductMovementRequest $new_product_movement)
    {
        $this->product_id = $product_id;
        $this->name = $name;
        $this->unit_price = $unit_price;
        $this->new_product_movement = $new_product_movement;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return float|null
     */
    public function getUnitPrice(): ?float
    {
        return $this->unit_price;
    }

    /**
     * @return AddProductMovementRequest|null
     */
    public function getNewProductMovement(): ?AddProductMovementRequest
    {
        return $this->new_product_movement;
    }
}
