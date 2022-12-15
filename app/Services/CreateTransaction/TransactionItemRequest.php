<?php

namespace App\Services\CreateTransaction;

class TransactionItemRequest
{
    private int $product_id;
    private float $quantity;

    /**
     * @param int $product_id
     * @param float $quantity
     */
    public function __construct(int $product_id, float $quantity)
    {
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }
}
