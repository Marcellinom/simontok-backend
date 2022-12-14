<?php

namespace App\Services\CreateCategory;

use App\Exceptions\ExpectedException;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class CreateCategoryService
{
    /**
     * @throws Exception
     */
    public function execute(CreateCategoryRequest $request, User $user): void
    {
        if (!$user->shop()->contains('id', $request->getShopId())) {
            ExpectedException::throw("shop not owned by user", 2040);
        }
        $category = Category::whereIn('name', $request->getName());
        if ($category->exists()) {
            $existing_category = join(", ", $category->get('name')->map(fn ($row) => $row->name)->toArray());
            ExpectedException::throw("category already exists!: {$existing_category}", 2041);
        }
        $payload = [];
        foreach ($request->getName() as $item) {
            $payload[] = [
                'shop_id' => $request->getShopId(),
                'name' => $item,
                'created_at' => Carbon::now()->getTimestamp()
            ];
        }
        Category::insert($payload);
    }
}
