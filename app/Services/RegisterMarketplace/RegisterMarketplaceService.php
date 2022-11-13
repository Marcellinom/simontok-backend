<?php

namespace App\Services\RegisterMarketplace;

use App\Exceptions\ExpectedException;
use App\Models\Marketplace;
use DB;

class RegisterMarketplaceService
{
    /**
     * @throws \Exception
     */
    public function execute(RegisterMarketplaceRequest $request)
    {
        $marketplace = DB::table('marketplace')->where('name', $request->getName())->first();
        if ($marketplace) ExpectedException::throw("Existing marketplace name", 1022);
        $marketplace = new Marketplace();
        $marketplace->setName($request->getName());
        $marketplace->setUserId($request->getUserId());
        $marketplace->persist();
    }
}
