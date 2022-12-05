<?php

namespace App\Services\GetShop;

class GetShopRequest
{
    private ?int $shop_id;

    /**
     * @param int|null $shop_id
     */
    public function __construct(?int $shop_id)
    {
        $this->shop_id = $shop_id;
    }

    /**
     * @return int|null
     */
    public function getShopId(): ?int
    {
        return $this->shop_id;
    }
}
