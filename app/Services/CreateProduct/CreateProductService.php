<?php

namespace App\Services\CreateProduct;

use App\Exceptions\ExpectedException;
use App\Models\Marketplace;
use App\Models\Product;
use App\Models\User;
use Exception;

class CreateProductService
{
    /**
     * @throws Exception
     */
    public function execute(CreateProductRequest $request, User $user)
    {
        $marketplace = Marketplace::where('id', $request->getMarketplaceId())->first();

        if (!$marketplace) ExpectedException::throw("Marketplace not found", 2024);

        if ($user->getId() !== $marketplace->getUserId()) ExpectedException::throw("Marketplace is not owned by user", 2025);

        if (Product::where('name', $request->getName())->exists()) ExpectedException::throw("product with the name {$request->getName()} already exists", 2026);

        $product = (new Product())
            ->setMarketplaceId($marketplace->getId())
            ->setName($request->getName())
            ->setUnitPrice($request->getUnitPrice());
        $product->persist();
    }
}
