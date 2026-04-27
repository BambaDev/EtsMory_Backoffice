<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API V1 Routes (Phase 3 — Mobile App)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->name('api.v1.')->group(function () {

    Route::get('health', fn () => response()->json(['status' => 'ok']));

    // Public endpoints (no auth)
    // Route::get('products', [Api\V1\ProductController::class, 'index']);
    // Route::get('products/{slug}', [Api\V1\ProductController::class, 'show']);
    // Route::get('categories', [Api\V1\CategoryController::class, 'index']);
    // Route::get('brands', [Api\V1\BrandController::class, 'index']);

    // Authenticated endpoints
    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::get('user', fn (Request $request) => $request->user());
    //     Route::apiResource('cart', Api\V1\CartController::class);
    //     Route::apiResource('orders', Api\V1\OrderController::class)->only(['index', 'show']);
    //     Route::apiResource('wishlist', Api\V1\WishlistController::class);
    // });
});
