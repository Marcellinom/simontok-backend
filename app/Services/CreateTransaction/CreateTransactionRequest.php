<?php

namespace App\Services\CreateTransaction;

use App\Models\TransactionItem;

class CreateTransactionRequest
{
    private int $marketplace_id;
    /**
     * @var array<TransactionItemRequest>
     */
    private array $items;

    /**
     * @param int $marketplace_id
     * @param TransactionItemRequest[] $items
     */
    public function __construct(int $marketplace_id, array $items)
    {
        $this->marketplace_id = $marketplace_id;
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getMarketplaceId(): int
    {
        return $this->marketplace_id;
    }

    /**
     * @return array<TransactionItemRequest>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
