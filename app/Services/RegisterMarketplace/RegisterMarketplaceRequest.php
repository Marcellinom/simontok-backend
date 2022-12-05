<?php

namespace App\Services\RegisterMarketplace;

class RegisterMarketplaceRequest
{
    private string $name;
    private int $user_id;
    private int $shop_id;

    /**
     * @param string $name
     * @param int $user_id
     * @param int $shop_id
     */
    public function __construct(string $name, int $user_id, int $shop_id)
    {
        $this->name = $name;
        $this->user_id = $user_id;
        $this->shop_id = $shop_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getShopId(): int
    {
        return $this->shop_id;
    }
}
