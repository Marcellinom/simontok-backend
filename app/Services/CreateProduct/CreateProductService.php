<?php

namespace App\Services\CreateProduct;

use App\Exceptions\ExpectedException;
use App\Models\Marketplace;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class CreateProductService
{
    /**
     * @throws Exception
     */
    public function execute(CreateProductRequest $request, User $user): void
    {
        $shop = Shop::where('id', $request->getShopId())->first();

        if (!$shop)
            ExpectedException::throw("Shop not found", 2024);

        if ($user->getId() !== $shop->user()?->getId())
            ExpectedException::throw("Marketplace is not owned by user", 2025);

        if (Product::where('name', $request->getName())->exists())
            ExpectedException::throw("product with the name {$request->getName()} already exists", 2026);

        $id = 'product/default.png';
        if ($request->getImage()) {
            $id = \Storage::disk('public')->put('product/', $request->getImage());
        }

        $product = Product::create([
            'shop_id' => $request->getShopId(),
            'name' => $request->getName(),
            'unit_price' => $request->getUnitPrice(),
            'created_at' => Carbon::now()->getTimestamp(),
            'image' => $id
        ]);

        $category_payload = [];
        foreach ($request->getCategoriesId() as $item) {
            $category_payload[] = [
                'product_id' => $product->getId(),
                'category_id' => $item
            ];
        }
        ProductCategory::where('product_id', $product->getId())->delete();
        ProductCategory::insert($category_payload);
    }
}
