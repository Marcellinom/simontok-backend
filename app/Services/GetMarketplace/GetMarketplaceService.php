<?php

namespace App\Services\GetMarketplace;

use App\Models\Marketplace;
use App\Models\User;

class GetMarketplaceService
{
    public function execute(GetMarketplaceRequest $request, User $user)
    {
        if ($request->getId()) return Marketplace::where('id', $request->getId())->first();
        return $user->marketplace();
    }
}
