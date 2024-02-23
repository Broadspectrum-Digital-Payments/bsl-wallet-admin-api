<?php

use Illuminate\Http\Request;
use App\Response\MessageResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\NewAdminPasswordResetController;

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


Route::post('/login', LoginController::class)
    ->middleware('guest')
    ->name('login');

Route::post('/reset-password', NewAdminPasswordResetController::class)
    ->middleware('guest')
    ->name('admin.veify');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AdminController::class)
        ->prefix('admins')
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{externalId}', 'show');
            Route::post('/', 'create');
            Route::put('/{externalId}', 'update');
            Route::delete('/{externalId}', 'destroy');
        });

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return MessageResponse::success(success: 'Logout successful');
    });
});
