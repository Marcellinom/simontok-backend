<?php

namespace App\Services\GetProduct;

class GetProductRequest
{
    private int $shop_id;
    private ?int $product_id;

    /**
     * @param int $shop_id
     * @param int|null $product_id
     */
    public function __construct(int $shop_id, ?int $product_id)
    {
        $this->shop_id = $shop_id;
        $this->product_id = $product_id;
    }

    /**
     * @return int
     */
    public function getShopId(): int
    {
        return $this->shop_id;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->product_id;
    }
}
