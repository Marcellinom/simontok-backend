<?php

use App\Http\Controllers\UserController;
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

Route::post('/register_user', [UserController::class, 'register']);
Route::post('/login_user', [UserController::class, 'login']);
Route::post('/send_otp', [UserController::class, 'sendOtp']);

Route::get('/', function () {
    $user = User::first();
    $user->setName('bababooey');
    $user->persist();
    dd(User::first());
});
