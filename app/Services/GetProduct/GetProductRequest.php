<?php

namespace App\Services\GetProduct;

class GetProductRequest
{
    private int $marketplace_id;
    private ?int $product_id;

    /**
     * @param int $marketplace_id
     * @param int|null $product_id
     */
    public function __construct(int $marketplace_id, ?int $product_id)
    {
        $this->marketplace_id = $marketplace_id;
        $this->product_id = $product_id;
    }

    /**
     * @return int
     */
    public function getMarketplaceId(): int
    {
        return $this->marketplace_id;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->product_id;
    }
}
