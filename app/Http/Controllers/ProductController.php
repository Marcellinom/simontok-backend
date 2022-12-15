<?php

namespace App\Http\Controllers;

use App\Services\CreateCategory\CreateCategoryRequest;
use App\Services\CreateCategory\CreateCategoryService;
use App\Services\CreateProduct\CreateProductRequest;
use App\Services\CreateProduct\CreateProductService;
use App\Services\EditProduct\AddProductMovementRequest;
use App\Services\EditProduct\EditProductRequest;
use App\Services\EditProduct\EditProductService;
use App\Services\GetCategory\GetCategoryRequest;
use App\Services\GetCategory\GetCategoryService;
use App\Services\GetProduct\GetProductRequest;
use App\Services\GetProduct\GetProductService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use function use_db_transaction;

class ProductController extends Controller
{
    /**
     * @throws Throwable
     */
    public function createProduct(Request $request, CreateProductService $service): JsonResponse
    {
        use_db_transaction(fn () => $service->execute(
            new CreateProductRequest(
                $request->input('marketplace_id'),
                $request->input('name'),
                (float)$request->input('unit_price'),
                $request->input('category'),
                $request->hasFile('image') ? $request->file('image') : null
            ),
            $request->user()
        ));

        return $this->success();
    }

    /**
     * @throws Throwable
     */
    public function editProduct(Request $request, EditProductService $service): JsonResponse
    {
        $edit_product_request = new EditProductRequest(
            $request->input('product_id'),
            $request->input('name'),
            $request->input('unit_price'),
            $request->input('stock')
                ? new AddProductMovementRequest($request->input('stock')['direction'], $request->input('stock')['quantity'])
                : null
        );

        use_db_transaction(fn () => $service->execute($edit_product_request, $request->user()));

        return $this->success();
    }

    public function getProduct(Request $request, GetProductService $service): JsonResponse
    {
        return $this->successWithData(
            $service->execute(new GetProductRequest(
                $request->query('marketplace_id'),
                $request->query('product_id')
            ))
        );
    }

    /**
     * @throws Throwable
     */
    public function CreateCategory(Request $request, CreateCategoryService $service): JsonResponse
    {
        use_db_transaction(fn () => $service->execute(new CreateCategoryRequest($request->input('names'), $request->input('shop_id')), $request->user()));
        return $this->success();
    }

    /**
     * @throws Exception
     */
    public function getCategories(Request $request, GetCategoryService $service): JsonResponse
    {
        return $this->successWithData($service->execute(new GetCategoryRequest($request->query('shop_id')), $request->user()));
    }
}
