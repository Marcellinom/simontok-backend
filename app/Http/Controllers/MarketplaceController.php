<?php

namespace App\Http\Controllers;

use App\Services\GetMarketplace\GetMarketplaceRequest;
use App\Services\GetMarketplace\GetMarketplaceService;
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
        $user = $request->user();
        $request = new RegisterMarketplaceRequest(
            $request->input('name'),
            $request->user()->id,
            $request->input('shop_id')
        );
        use_db_transaction(fn () => $service->execute($request, $user));
        return $this->success();
    }
    public function getMarketPlace(Request $request, GetMarketplaceService $service): JsonResponse
    {
        return $this->successWithData(
            $service->execute(new GetMarketplaceRequest($request->query('id')), $request->user())
        );
    }
}
