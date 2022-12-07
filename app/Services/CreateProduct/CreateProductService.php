<?php

namespace App\Services\CreateProduct;

use App\Exceptions\ExpectedException;
use App\Models\Marketplace;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class CreateProductService
{
    /**
     * @throws Exception
     */
    public function execute(CreateProductRequest $request, User $user)
    {
        $marketplace = Marketplace::where('id', $request->getMarketplaceId())->first();

        if (!$marketplace)
            ExpectedException::throw("Marketplace not found", 2024);

        if ($user->getId() !== $marketplace->user()?->getId())
            ExpectedException::throw("Marketplace is not owned by user", 2025);

        if (Product::where('name', $request->getName())->exists())
            ExpectedException::throw("product with the name {$request->getName()} already exists", 2026);

        $id = 'product/default.png';
        if ($request->getImage()) {
            $id = \Storage::disk('public')->put('product/', $request->getImage());
        }

        Product::persist(new Product([
            'id' => null,
            'marketplace_id' => $request->getMarketplaceId(),
            'name' => $request->getName(),
            'unit_price' => $request->getUnitPrice(),
            'created_at' => Carbon::now(),
            'image' => $id,
            'category' => $request->getCategory()
        ]));
    }
}
