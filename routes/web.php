<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('products', [ProductController::class, 'index'])->name('products');
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        
        Route::post('products/{id}/pricing-options', [ProductController::class, 'addPricingOption'])->name('products.pricing.add');
        Route::put('pricing-options/{optionId}', [ProductController::class, 'updatePricingOption'])->name('products.pricing.update');
        Route::delete('pricing-options/{optionId}', [ProductController::class, 'deletePricingOption'])->name('products.pricing.delete');
        
        Route::post('products/{id}/images', [ProductImageController::class, 'store'])->name('products.images.add');
        Route::delete('product-images/{id}', [ProductImageController::class, 'destroy'])->name('products.images.delete');
        
        Route::get('categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        
        Route::get('orders', [OrderController::class, 'index'])->name('orders');
        Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        
        Route::get('testimonials', [TestimonialController::class, 'index'])->name('testimonials');
        Route::get('testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create');
        Route::post('testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
        Route::get('testimonials/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
        Route::put('testimonials/{id}', [TestimonialController::class, 'update'])->name('testimonials.update');
        Route::delete('testimonials/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
        
        Route::get('sliders', [SliderController::class, 'index'])->name('sliders');
        Route::get('sliders/create', [SliderController::class, 'create'])->name('sliders.create');
        Route::post('sliders', [SliderController::class, 'store'])->name('sliders.store');
        Route::get('sliders/{id}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
        Route::put('sliders/{id}', [SliderController::class, 'update'])->name('sliders.update');
        Route::delete('sliders/{id}', [SliderController::class, 'destroy'])->name('sliders.destroy');
    });
});

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/category/{slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/shop/product/{slug}', [ShopController::class, 'product'])->name('shop.product');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{slug}', [CartController::class, 'add'])->name('add');
    Route::put('/update/{itemKey}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{itemKey}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{orderNumber}', [CheckoutController::class, 'success'])->name('success');
});

Route::get('/custom-quote', function () {
    return view('front.custom-quote');
})->name('custom.quote');

Route::post('/newsletter/subscribe', function (\Illuminate\Http\Request $request) {
    return back()->with('success', 'Thank you for subscribing!');
})->name('newsletter.subscribe');