<?php

namespace App\Services\Statistic;

use App\Models\Shared\JsonSerialize;
use App\Models\Transaction;
use App\Models\User;

class StatisticService
{
    public function execute(User $user): JsonSerialize
    {
        $marketplace_ids = [];
        foreach ($user->shop() as $shop) {
            foreach ($shop->marketplace() as $marketplace) {
                $marketplace_ids[] = $marketplace->getId();
            }
        }
        return JsonSerialize::make([
            'income' => Transaction::whereIn('marketplace_id', $marketplace_ids)->sum('total_price')
        ]);
    }
}
