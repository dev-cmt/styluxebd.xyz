<?php

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

Auth::routes();

// @dd(564546);

// all product
// Route::get('/all-products', function (Request $request) {
//     $theme = activeTheme();

//     return activeThemeController($request, $theme, 'allProducts');
// })->name('all.products');

Route::get('{path}/all-products', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'allProducts');
})->name('theme.all.products');

// add to cart
Route::post('/cart-add', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'add');
})->name('cart.add');

Route::post('{path}/cart-add', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'add');
})->name('theme.cart.add');

// order now
Route::post('/order-now', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'orderNow');
})->name('order.now');

Route::post('{path}/order-now', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'orderNow');
})->name('theme.order.now');

// mini cart
Route::get('/mini-cart', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'miniCart');
})->name('mini.cart');

Route::get('{path}/mini-cart', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'miniCart');
})->name('theme.mini.cart');

// cart remove
Route::post('/cart/remove', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'remove');
})->name('cart.remove');

Route::post('{path}/cart/remove', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'remove');
})->name('theme.cart.remove');

// cart update qty
Route::post('/cart/update/qty', function (Request $request) {
    $theme = activeTheme();

    // dd($theme);
    return activeThemeController($request, $theme, 'updateQty');
})->name('update.qty');

Route::post('{path}/cart/update/qty', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'updateQty');
})->name('theme.update.qty');

// checkout cart remove
Route::post('/checkout/cart-remove', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'checkoutRemove');
})->name('checkout.cart.remove');

Route::post('{path}/checkout/cart-remove', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'checkoutRemove');
})->name('theme.checkout.cart.remove');

// checkout cart update qty
Route::post('/checkout/qty-update', function (Request $request) {
    $theme = activeTheme();

    // dd($theme);
    return activeThemeController($request, $theme, 'checkoutUpdateQty');
})->name('checkout.cart.updateQty');

Route::post('{path}/checkout/qty-update', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'checkoutUpdateQty');
})->name('theme.checkout.cart.updateQty');

// checkout cart shipping
Route::post('/checkout/cart/shipping', function (Request $request) {
    $theme = activeTheme();

    return activeThemeController($request, $theme, 'checkoutShipping');
})->name('checkout.cart.shipping');

Route::post('{path}/checkout/cart/shipping', function (Request $request, $path) {
    $theme = Theme::where('path', $path)->first();

    return activeThemeController($request, $theme, 'checkoutShipping');
})->name('theme.checkout.cart.shipping');
