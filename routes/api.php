<?php

use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\UserController;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum', 'must_verify_email'])->group(function () {
    Route::post('/register_marketplace', [MarketplaceController::class, 'registerMarketplace']);
});
Route::post('/reset_password', [UserController::class, 'reset_password']);
Route::post('/register_user', [UserController::class, 'register']);
Route::post('/forgot_password', [UserController::class, 'forgot_password']);
Route::post('/login_user', [UserController::class, 'login']);
Route::post('/send_otp', [UserController::class, 'sendOtp']);
Route::post('verify_otp', [UserController::class, 'verifyOtp']);

Route::get('/', function () {
    $user = User::find(1);
    dd($user->otp());
});
