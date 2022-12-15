<?php

namespace App\Services\GetCategory;

class GetCategoryRequest
{
    private int $shop_id;

    /**
     * @param int $shop_id
     */
    public function __construct(int $shop_id)
    {
        $this->shop_id = $shop_id;
    }

    /**
     * @return int
     */
    public function getShopId(): int
    {
        return $this->shop_id;
    }
}
