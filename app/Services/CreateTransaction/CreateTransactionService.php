<?php

namespace App\Services\CreateTransaction;

use App\Exceptions\ExpectedException;
use App\Jobs\AddProductMovementJobs;
use App\Models\Marketplace;
use App\Models\Product;
use App\Models\ProductMovement;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Exception;

class CreateTransactionService
{
    /**
     * @throws Exception
     */
    public function execute(CreateTransactionRequest $request): void
    {
        $price_total = 0;
        $item_payload = [];
        $marketplace = Marketplace::where('id', $request->getMarketplaceId())->first();
        if (!$marketplace) ExpectedException::throw("Marketplace doesn't exists", 2045);
        foreach ($request->getItems() as $item) {
            $product = Product::where('id', $item->getProductId())->first();
            $price_total += $product->getUnitPrice() * $item->getQuantity();
            $item_payload[] = [
                "product_id" => $product->getId(),
                "quantity" => $item->getQuantity()
            ];
            $product_movement = ProductMovement::generate($marketplace->user()?->getId(), $product->getId(), 'out', $item->getQuantity());
            AddProductMovementJobs::publish($product_movement);
        }
        $transaction = Transaction::create([
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
