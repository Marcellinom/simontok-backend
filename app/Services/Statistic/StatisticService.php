<?php

namespace App\Services\Statistic;

use App\Models\Shared\JsonSerialize;
use App\Models\Transaction;
use App\Models\User;
class StatisticService
{
    public function execute(User $user): JsonSerialize
    {
        $marketplace_ids = [];;
        foreach ($user->shop() as $shop) {
            foreach ($shop->marketplace() as $marketplace) {
                $marketplace_ids[] = $marketplace->getId();
            }
        }
        $transaction = Transaction::whereIn('marketplace_id', $marketplace_ids);
        $income = $transaction->sum('total_price');
        $items_history = [];
        $i = 0;
        foreach ($transaction->get() as $transaction) {
            /** @var Transaction $transaction */
            foreach ($transaction->getItems() as $item) {
                $product = $item->product();
                $items_history[$i]['product_name'] = $product->getName();
                $items_history[$i]['quantity'] = $item->getQuantity();
                $items_history[$i]['transaction_at'] = $transaction->getCreatedAt();
                if ($i++>=10) break;
            }
        }
        return JsonSerialize::make([
            'income' => $income,
            'transaction_item_history' =>$items_history
        ]);
    }
}
