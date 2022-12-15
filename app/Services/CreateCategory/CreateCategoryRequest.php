<?php

namespace App\Services\CreateCategory;

class CreateCategoryRequest
{
    private array $name;
    private int $shop_id;

    /**
     * @param array $name
     * @param int $shop_id
     */
    public function __construct(array $name, int $shop_id)
    {
        $this->name = $name;
        $this->shop_id = $shop_id;
    }

    /**
     * @return array
     */
    public function getName(): array
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getShopId(): int
    {
        return $this->shop_id;
    }
}
