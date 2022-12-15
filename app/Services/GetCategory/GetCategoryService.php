<?php

namespace App\Services\GetCategory;

use App\Exceptions\ExpectedException;
use App\Models\Category;
use App\Models\User;

class GetCategoryService
{
    /**
     * @throws \Exception
     */
    public function execute(GetCategoryRequest $request, User $user)
    {
        if (!$user->shop()->contains('id', $request->getShopId())) {
            ExpectedException::throw("shop not owned by user", 2040);
        }
        return Category::where('shop_id', $request->getShopId())->get();
    }
}
