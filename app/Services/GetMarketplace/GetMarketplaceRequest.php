<?php

namespace App\Services\GetMarketplace;

class GetMarketplaceRequest
{
    private ?int $shop_id;
    private ?int $id;

    /**
     * @param int|null $shop_id
     * @param int|null $id
     */
    public function __construct(?int $shop_id, ?int $id)
    {
        $this->shop_id = $shop_id;
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getShopId(): ?int
    {
        return $this->shop_id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

}
