<?php

namespace App\Services\CreateTransaction;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Carbon\Carbon;

class CreateTransactionService
{
    public function execute(CreateTransactionRequest $request, User $user): void
    {
        $price_total = 0;
        $item_payload = [];
        foreach ($request->getItems() as $item) {
            $product = Product::where('id', $item->getProductId())->first();
            $price_total += $product->getUnitPrice() * $item->getQuantity();
            $item_payload[] = [
                "product_id" => $product->getId(),
                "quantity" => $item->getQuantity()
            ];
        }
        $transaction = Transaction::create([
            'user_id' => $user->getId(),
            'marketplace_id' => $request->getMarketplaceId(),
            'created_at' => Carbon::now()->getTimestamp(),
            'total_price' => $price_total
        ]);

        TransactionItem::insert(array_map(function($payload) use ($transaction) {
            $payload['transaction_id'] = $transaction->getId();
            return $payload;
        }, $item_payload));
    }
}
