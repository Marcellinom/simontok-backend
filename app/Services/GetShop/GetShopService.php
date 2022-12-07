<?php

namespace App\Services\GetShop;

use App\Models\Shop;
use App\Models\User;

class GetShopService
{
    public function execute(GetShopRequest $request, User $user)
    {
        if (!$request->getShopId()) return Shop::where('user_id', $user->getId())->get();
        return Shop::where('user_id', $user->getId())->where('id', $request->getShopId())->first();
    }
}
