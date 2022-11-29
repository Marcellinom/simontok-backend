<?php

namespace App\Http\Controllers;

use App\Services\CreateProduct\CreateProductRequest;
use App\Services\CreateProduct\CreateProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use function use_db_transaction;

class ProductController extends Controller
{
    /**
     * @throws Throwable
     */
    public function create_product(Request $request, CreateProductService $service): JsonResponse
    {
        use_db_transaction(fn () => $service->execute(
            new CreateProductRequest(
                $request->input('marketplace_id'),
                $request->input('name'),
                (float)$request->input('unit_price')
            ),
            $request->user()
        ));

        return $this->success();
    }
}
