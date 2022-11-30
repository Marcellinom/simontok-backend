<?php

namespace App\Services\EditProduct;

class AddProductMovementRequest
{
    private string $direction;
    private string $quantity;

    /**
     * @param string $direction
     * @param string $quantity
     */
    public function __construct(string $direction, string $quantity)
    {
        $this->direction = $direction;
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @return string
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }
}
