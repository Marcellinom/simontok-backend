<?php

namespace App\Services\CreateShop;

use App\Exceptions\ExpectedException;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class CreateShopService
{
    /**
     * @throws Exception
     */
    public function execute(CreateShopRequest $request, User $user)
    {
        if (Shop::where('user_id', $user->getId())->where('name', $request->getName())->exists())
            ExpectedException::throw("Existing shop with the same name", 2041);
        Shop::persist(new Shop([
            'id' => null,
            'user_id' => $user->getId(),
            'name' => $request->getName(),
            'created_at' => Carbon::now()
        ]));
    }
}
