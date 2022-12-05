<?php

namespace App\Services\EditProduct;

use App\Exceptions\ExpectedException;
use App\Jobs\AddProductMovementJobs;
use App\Models\Product;
use App\Models\ProductMovement;
use App\Models\User;
use Exception;

class EditProductService
{
    /**
     * @throws Exception
     */
    public function execute(EditProductRequest $request, User $user)
    {
        $product = Product::where('id', $request->getProductId())->first();

        if (!$product) ExpectedException::throw("Product not found", 2027);

        $product->setName($request->getName() ?? $product->getName());
        $product->setUnitPrice($request->getUnitPrice() ?? $product->getUnitPrice());
        Product::persist($product);

        if ($request->getNewProductMovement()) {
            $product_movement = ProductMovement::generate(
                $user->getId(),
                $product->getId(),
                $request->getNewProductMovement()->getDirection(),
                $request->getNewProductMovement()->getQuantity()
            );
            AddProductMovementJobs::publish($product_movement);
        }
    }
}
