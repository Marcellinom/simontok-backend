<?php

namespace App\Services\GetProduct;


use App\Models\Marketplace;
use App\Models\Product;

class GetProductService
{
    public function execute(GetProductRequest $request)
    {
        if ($request->getProductId()) return Product::where('marketplace_id', $request->getMarketplaceId())
            ->where('id', $request->getProductId())->first();
        return Marketplace::where('id', $request->getMarketplaceId())->first()?->products();
    }
}
