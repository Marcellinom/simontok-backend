<?php

namespace App\Services\RegisterMarketplace;

use App\Exceptions\ExpectedException;
use App\Models\Marketplace;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use DB;

class RegisterMarketplaceService
{
    /**
     * @throws \Exception
     */
    public function execute(RegisterMarketplaceRequest $request, User $user)
    {
        if (DB::table('marketplace')->where('name', $request->getName())->exists())
            ExpectedException::throw("Existing marketplace name", 1022);
        if (!Shop::where('user_id', $user->getId())->where('id', $request->getShopId())->exists())
            ExpectedException::throw("shop not found", 2042);

        Marketplace::persist(new Marketplace([
            'id' => null,
            'shop_id' => $request->getShopId(),
            'name' => $request->getName(),
            'created_at' => Carbon::now()
        ]));
    }
}
