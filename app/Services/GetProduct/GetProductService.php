<?php

namespace App\Services\GetProduct;


use App\Models\Marketplace;
use App\Models\Product;
use App\Models\ProductMovement;
use App\Models\Shared\JsonSerialize;
use Exception;
use Illuminate\Support\Collection;
use function count;

class GetProductService
{
    /**
     * @throws Exception
     */
    public function execute(GetProductRequest $request)
    {
        if ($request->getProductId()) {
            $product =  Product::where('marketplace_id', $request->getMarketplaceId())
                ->where('id', $request->getProductId())->first();
            $stock = $this->countStock($product_movement = $product->productMovement());
            return $this->serialize([
                'id' => $product->getId(),
                'name' => $product->getName(),
                'unit_price' => $product->getUnitPrice(),
                'created_at' => $product->getCreatedAt(),
                'image' => $product->getImage(),
                'stock' => $stock,
                'movement' => $product_movement
            ]);
        }
        return Marketplace::where('id', $request->getMarketplaceId())->first()?->products()->map(function (Product $product) {
            $stock = $this->countStock($product_movement = $product->productMovement());
            return $this->serialize([
                'id' => $product->getId(),
                'name' => $product->getName(),
                'unit_price' => $product->getUnitPrice(),
                'created_at' => $product->getCreatedAt(),
                'image' => $product->getImage(),
                'stock' => $stock,
                'movement' => $product_movement->map(function (ProductMovement $movement) {
                    return [
                        'id' => $movement->getId(),
                        'reference_id' => $movement->getReferenceId(),
                        'actor_user_id' => $movement->getUserId(),
                        'direction' => $movement->getDirection(),
                        'quantity' => $movement->getQuantity(),
                        'created_at' => $movement->getCreatedAt()
                    ];
                })
            ]);
        });
    }

    /**
     * @param ProductMovement[] $product_movements
     * @return float
     * @throws Exception
     */
    private function countStock(Collection|array $product_movements): float
    {
        $stock = 0;
        for ($i = 0 ;$i < count($product_movements); $i++) {
            $stock += $product_movements[$i]->isDirection(ProductMovement::DIRECTION('out'))
                ? -$product_movements[$i]->getQuantity()
                : $product_movements[$i]->getQuantity();
        }
        return $stock;
    }

    private function serialize(array $data): JsonSerialize
    {
        return JsonSerialize::make($data);
    }
}
