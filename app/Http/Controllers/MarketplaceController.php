<?php

namespace App\Http\Controllers;

use App\Services\RegisterMarketplace\RegisterMarketplaceRequest;
use App\Services\RegisterMarketplace\RegisterMarketplaceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class MarketplaceController extends Controller
{
    /**
     * @throws Throwable
     */
    public function registerMarketplace(Request $request, RegisterMarketplaceService $service): JsonResponse
    {
        $request = new RegisterMarketplaceRequest($request->input('name'), $request->user()->id);
        use_db_transaction(fn () => $service->execute($request));
        return $this->success();
    }
}
