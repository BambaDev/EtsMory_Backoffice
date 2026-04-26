<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Gateway\PaymentController as GatewayPaymentController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\SiteController;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// User Support Ticket
Route::controller(TicketController::class)->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});

Route::get('app/deposit/confirm/{hash}', [GatewayPaymentController::class, 'appDepositConfirm'])->name('deposit.app.confirm');

Route::controller(CartController::class)->name('cart.')->group(function () {
    Route::get('cart', 'cart')->name('page');
    Route::post('add-to-cart/{productId}', 'addToCart')->name('add');
    Route::post('cart-update/{id}', 'updateCartItem')->name('update');
    Route::get('cart-shortlist', 'partialCart')->name('shortlist');
    Route::get('cart-items-count', 'cartItemsCount')->name('items.count');
    Route::get('cart-subtotal', 'cartSubtotal')->name('items.subtotal');
    Route::post('remove-from-cart/{id}', 'removeCartItem')->name('remove');
    Route::post('apply-coupon', 'applyCoupon')->name('coupon.apply');
    Route::post('remove-coupon', 'removeCoupon')->name('coupon.remove');
});

Route::controller(WishlistController::class)->name('wishlist.')->group(function () {
    Route::get('wishlist', 'wishList')->name('page');
    Route::post('add-to-wishlist/{productId}', 'addToWishList')->name('add');
    Route::get('wishlist-short', 'partialWishlist')->name('shortlist');
    Route::get('wishlist-count', 'wishlistItemsCount')->name('items.count');
    Route::post('remove-from-wishlist/{id}', 'remove')->name('remove');
});

Route::controller(ProductController::class)->name('product.')->group(function () {
    Route::get('products', 'products')->name('all');
    Route::get('products/{category}', 'productByCategory')->name('by.category');
    Route::get('{slug}/products', 'productsByBrand')->name('by.brand');
    Route::get('product/{slug}', 'productDetails')->name('detail');
    Route::get('products/{id}/reviews', 'reviews')->name('reviews');
    Route::get('product/{slug}/stock-by-variant', 'geStockByVariant')->name('variant.stock');
    Route::get('images-by-variant/{productId}', 'getImagesByVariant')->name('variant.image');
    Route::get('compare-wishlist-cart-date', 'compareWishlistAndCartData')->name('compare.wishlist.cart.data');
});

Route::controller(CompareController::class)->name('compare.')->group(function () {
    Route::get('compare-products', 'compare')->name('all');
    Route::post('add-to-compare', 'addToCompare')->name('add');
    Route::get('compare-products-count', 'compareProductsCount')->name('count');
    Route::post('remove-from-compare/{id?}', 'removeFromCompare')->name('remove');
});

Route::name('checkout.')->group(function () {
    Route::controller(CheckoutController::class)->group(function () {
        Route::post('store-guest-info', 'storeGuestUser')->name('guest.info.store')->middleware('checkModule:guest_checkout');
        Route::post('store-guest-shipping-info', 'storeGuestShippingInfo')->name('guest.shipping.info.store')->middleware('checkModule:guest_checkout');
        Route::get('checkout/shipping-info', 'shippingInfo')->name('shipping.info')->middleware('checkout.step:shipping_info');
        Route::post('add-shipping-address', 'addShippingInfo')->name('shipping.info.add')->middleware('checkout.step:shipping_info');
        Route::get('checkout/delivery-methods', 'deliveryMethods')->name('delivery.methods')->middleware('checkout.step:delivery_method');
        Route::post('add-delivery-method', 'addDeliveryMethod')->name('delivery.method.add')->middleware('checkout.step:delivery_method');
        Route::get('order-confirmation/{order}', 'confirmation')->name('confirmation');
    });

    Route::controller(PaymentController::class)->group(function () {
        Route::get('checkout/payment-methods', 'paymentMethods')->name('payment.methods')->middleware('checkout.step:payment');
        Route::post('complete-checkout', 'completeCheckout')->name('complete')->middleware('checkout.step:payment');
    });
});

// Payment
Route::prefix('deposit')->name('deposit.')->controller(GatewayPaymentController::class)->group(function () {
    Route::get('confirm', 'depositConfirm')->name('confirm');
    Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
    Route::post('manual', 'manualDepositUpdate')->name('manual.update');
});

Route::controller(OrderController::class)->group(function () {
    Route::get('orders/{order_number}', 'orderDetails')->name('orders.details');
    Route::get('digital-item/download/{id}', 'download')->name('order.item.download');
});

Route::controller(SiteController::class)->group(function () {
    Route::get('categories', 'categories')->name('categories');
    Route::get('brands', 'brands')->name('brands');
    Route::get('track-order', 'trackOrder')->name('order.track');
    Route::get('order-data/{order_number}', 'getOrderTrackData')->name('track.order');
    Route::post('subscribe', 'addSubscriber')->name('subscribe');
    Route::get('faq', 'faq')->name('faq');
    Route::get('about-us', 'about')->name('about');

    Route::get('offers', 'offers')->name('offers');
    Route::get('offer-products/{id}', 'offerProducts')->name('offer.products');

    Route::get('/contact', 'contact')->name('contact');
    Route::post('contact-submit', 'contactSubmit')->name('contact.submit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');
    Route::get('maintenance-mode', 'maintenance')->withoutMiddleware('maintenance')->name('maintenance');

    Route::get('/', 'index')->name('home');
});
