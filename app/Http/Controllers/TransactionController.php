<?php

namespace App\Http\Controllers;

use App\Services\CreateTransaction\CreateTransactionRequest;
use App\Services\CreateTransaction\CreateTransactionService;
use App\Services\CreateTransaction\TransactionItemRequest;
use Illuminate\Http\Request;
use Throwable;

class TransactionController extends Controller
{
    /**
     * @throws Throwable
     */
    public function createTransaction(Request $request, CreateTransactionService $service)
    {
        use_db_transaction(fn () => $service->execute(
            new CreateTransactionRequest(
                $request->input('marketplace_id'),
                array_map(function ($item) {
                    return new TransactionItemRequest($item['product_id'], $item['quantity']);
                }, $request->input('items'))
            ), $request->user()
        ));
        return $this->success();
    }
}
