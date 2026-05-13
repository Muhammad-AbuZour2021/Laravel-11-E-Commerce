<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishListController;
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'productDetails'])->name('shop.product.details');



Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::put('/cart/increase/{rowId}', [CartController::class, 'increaseQuantity'])->name('cart.increase');
Route::put('/cart/decrease/{rowId}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'removeCart'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/place-an-order', [CartController::class, 'place_an_order'])->name('cart.place.an.order');
Route::get('/orders-confirmation', [CartController::class, 'orders_confirmation'])->name('cart.orders.confirmation');


Route::post('/wishlist/add', [WishListController::class, 'addToWishlist'])->name('wishlist.add');


Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('/account-orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/account-orders/details/{order_id}', [UserController::class, 'orders_details'])->name('user.orders.datails');
    Route::post('/account-order/cancel', [OrderController::class, 'order_cancel'])->name('user.order.cancel');

});

Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    //Route is brands
    Route::get('/admin/brands', [BrandController::class, 'show'])->name('admin.brands');
    Route::get('/admin/brands/add', [BrandController::class, 'create'])->name('admin.brands.add');
    Route::post('/admin/brands/store', [BrandController::class, 'store'])->name('admin.brands.store');
    Route::get('/admin/brands/edit/{id}', [BrandController::class, 'edit'])->name('admin.brands.edit');
    Route::put('/admin/brands/update', [BrandController::class, 'update'])->name('admin.brands.update');
    Route::delete('/admin/brands/delete', [BrandController::class, 'destroy'])->name('admin.brands.delete');
    //Route is Category
    Route::get('/admin/categorys', [CategoryController::class, 'show'])->name('admin.categorys');
    Route::get('/admin/categorys/add', [CategoryController::class, 'create'])->name('admin.categorys.add');
    Route::post('/admin/categorys/store', [CategoryController::class, 'store'])->name('admin.categorys.store');
    Route::get('/admin/categorys/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categorys.edit');
    Route::put('/admin/categorys/update', [CategoryController::class, 'update'])->name('admin.categorys.update');
    Route::delete('/admin/categorys/delete', [CategoryController::class, 'destroy'])->name('admin.categorys.delete');
    //Route is Product
    Route::get('/admin/Product', [ProductController::class, 'show'])->name('admin.product');
    Route::get('/admin/Product/add', [ProductController::class, 'create'])->name('admin.product.add');
    Route::post('/admin/Product/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/admin/Product/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');

Route::put('/admin/product/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');

    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])
        ->name('admin.product.delete');






    Route::get('/admin/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('admin.orders');
    Route::get('/admin/orders/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/update', [App\Http\Controllers\OrderController::class, 'update_status'])->name('admin.orders.update.status');

    Route::get('/admin/slides', [App\Http\Controllers\AdminController::class, 'slides'])->name('admin.slides');
    Route::get('/admin/slides/add', [App\Http\Controllers\AdminController::class, 'slides_add'])->name('admin.slides.add');
    Route::post('/admin/slides/store', [AdminController::class, 'slides_store'])->name('admin.slides.store');
    Route::get('/admin/slides/edit/{id}', [App\Http\Controllers\AdminController::class, 'slides_edit'])->name('admin.slides.edit');
    Route::put('/admin/slides/update', [AdminController::class, 'slides_update'])->name('admin.slides.update');
    Route::delete('/admin/slides/delete/{id}', [App\Http\Controllers\AdminController::class, 'slides_delete'])->name('admin.slides.delete');


Route::put('/admin/users/update/{id}', [AdminController::class, 'update'])->name('admin.users.update');

});


Route::prefix('admin/users')->group(function () {

    Route::get('/', [AdminController::class, 'user'])->name('admin.users');
    Route::get('/add', [AdminController::class, 'create'])->name('admin.users.add');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.users.delete');

});
