<?php

use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\MediaLibraryController;
use App\Http\Controllers\Admin\PricingOptionTypeController;
use App\Http\Controllers\Webhook\StripeWebhookController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ShippingMethodController;
use App\Http\Controllers\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Newsletter\NewsletterController;
use App\Http\Controllers\Admin\ContactInquiryController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoftwareDevelopment\SoftwareDevelopmentController as SoftwareDevelopmentController;
use App\Http\Controllers\Admin\SoftwareDevelopmentController as AdminSoftwareDevelopmentController;
use App\Http\Controllers\SitemapController;

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
        Route::post('products/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');

        Route::post('products/{product}/file-setup', [ProductController::class, 'saveFileSetup'])->name('products.file-setup');
        Route::post('products/{product}/templates', [ProductController::class, 'addTemplate'])->name('products.templates.add');
        Route::delete('products/templates/{template}', [ProductController::class, 'deleteTemplate'])->name('products.templates.delete');

        Route::post('products/{product}/pricing-options', [ProductController::class, 'addPricingOption'])->name('products.pricing.add');
        Route::put('pricing-options/{option}', [ProductController::class, 'updatePricingOption'])->name('products.pricing.update');
        Route::delete('pricing-options/{option}', [ProductController::class, 'deletePricingOption'])->name('products.pricing.delete');
        Route::get('pricing-options/choices/{optionId}/{optionType}', [ProductController::class, 'getAffectedOptionChoices']);

        Route::post('products/{product}/images', [ProductImageController::class, 'store'])->name('products.images.add');
        Route::delete('product-images/{image}', [ProductImageController::class, 'destroy'])->name('products.images.delete');
        Route::post('products/{product}/attach-images', [ProductImageController::class, 'attach'])->name('products.images.attach');

        // Media Library
        Route::get('media-library', [MediaLibraryController::class, 'index'])->name('media-library');
        Route::get('media-library/api/list', [MediaLibraryController::class, 'getList'])->name('media-library.api.list');
        Route::post('media-library/upload', [MediaLibraryController::class, 'upload'])->name('media-library.upload');
        Route::delete('media-library/{id}', [MediaLibraryController::class, 'destroy'])->name('media-library.destroy');
        Route::post('media-library/{id}/primary', [MediaLibraryController::class, 'setPrimary'])->name('media-library.primary');
        Route::put('media-library/{id}', [MediaLibraryController::class, 'update'])->name('media-library.update');
        
        Route::get('categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
        
        Route::get('orders', [OrderController::class, 'index'])->name('orders');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::get('orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
        Route::post('orders/{order}/send-invoice', [OrderController::class, 'sendInvoice'])->name('orders.send-invoice');
        
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
        
        Route::get('pricing-option-types', [PricingOptionTypeController::class, 'index'])->name('pricing-option-types');
        Route::post('pricing-option-types', [PricingOptionTypeController::class, 'store'])->name('pricing-option-types.store');
        Route::put('pricing-option-types/{id}', [PricingOptionTypeController::class, 'update'])->name('pricing-option-types.update');
        Route::delete('pricing-option-types/{id}', [PricingOptionTypeController::class, 'destroy'])->name('pricing-option-types.destroy');
        Route::post('pricing-option-types/{id}/toggle', [PricingOptionTypeController::class, 'toggleStatus'])->name('pricing-option-types.toggle');
        
        Route::get('settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
        
        Route::get('coupons', [CouponController::class, 'index'])->name('coupons');
        Route::post('coupons', [CouponController::class, 'store'])->name('coupons.store');
        Route::put('coupons/{coupon}', [CouponController::class, 'update'])->name('coupons.update');
        Route::delete('coupons/{coupon}', [CouponController::class, 'destroy'])->name('coupons.destroy');
        Route::post('coupons/{coupon}/toggle', [CouponController::class, 'toggle'])->name('coupons.toggle');
        
        Route::get('shipping-methods', [ShippingMethodController::class, 'index'])->name('shipping-methods');
        Route::post('shipping-methods', [ShippingMethodController::class, 'store'])->name('shipping-methods.store');
        Route::put('shipping-methods/{shippingMethod}', [ShippingMethodController::class, 'update'])->name('shipping-methods.update');
        Route::delete('shipping-methods/{shippingMethod}', [ShippingMethodController::class, 'destroy'])->name('shipping-methods.destroy');
        Route::post('shipping-methods/{shippingMethod}/toggle', [ShippingMethodController::class, 'toggle'])->name('shipping-methods.toggle');
        
        Route::get('newsletter', [NewsletterSubscriberController::class, 'index'])->name('newsletter');
        Route::post('newsletter/{subscriber}/toggle', [NewsletterSubscriberController::class, 'toggle'])->name('newsletter.toggle');
        Route::delete('newsletter/{subscriber}', [NewsletterSubscriberController::class, 'destroy'])->name('newsletter.destroy');
        Route::post('newsletter/bulk-delete', [NewsletterSubscriberController::class, 'bulkDelete'])->name('newsletter.bulk-delete');
        Route::get('newsletter/export', [NewsletterSubscriberController::class, 'export'])->name('newsletter.export');
        
        Route::get('contact-inquiries', [ContactInquiryController::class, 'index'])->name('contact-inquiries');
        Route::get('contact-inquiries/{contactInquiry}', [ContactInquiryController::class, 'show'])->name('contact-inquiries.show');
        Route::post('contact-inquiries/{contactInquiry}/reply', [ContactInquiryController::class, 'reply'])->name('contact-inquiries.reply');
        Route::delete('contact-inquiries/{contactInquiry}', [ContactInquiryController::class, 'destroy'])->name('contact-inquiries.destroy');
        
        Route::get('email-templates', [EmailTemplateController::class, 'index'])->name('email-templates.index');
        Route::get('email-templates/create', [EmailTemplateController::class, 'create'])->name('email-templates.create');
        Route::post('email-templates', [EmailTemplateController::class, 'store'])->name('email-templates.store');
        Route::get('email-templates/{emailTemplate}/edit', [EmailTemplateController::class, 'edit'])->name('email-templates.edit');
        Route::put('email-templates/{emailTemplate}', [EmailTemplateController::class, 'update'])->name('email-templates.update');
        Route::delete('email-templates/{emailTemplate}', [EmailTemplateController::class, 'destroy'])->name('email-templates.destroy');
        
        Route::get('menu-items', [MenuItemController::class, 'index'])->name('menu-items');
        Route::post('menu-items', [MenuItemController::class, 'store'])->name('menu-items.store');
        Route::get('menu-items/{id}/edit', [MenuItemController::class, 'edit'])->name('menu-items.edit');
        Route::put('menu-items/{id}', [MenuItemController::class, 'update'])->name('menu-items.update');
        Route::delete('menu-items/{id}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');
        Route::post('menu-items/{id}/toggle', [MenuItemController::class, 'toggle'])->name('menu-items.toggle');
        
        Route::get('home-page', [HomePageController::class, 'index'])->name('home-page');
        Route::put('home-page/reorder', [HomePageController::class, 'reorder'])->name('home-page.reorder');
        Route::put('home-page/{id}', [HomePageController::class, 'update'])->name('home-page.update');
        Route::post('home-page/{id}/toggle', [HomePageController::class, 'toggle'])->name('home-page.toggle');
        Route::post('home-page/add/{key}', [HomePageController::class, 'add'])->name('home-page.add');
        Route::delete('home-page/{id}', [HomePageController::class, 'remove'])->name('home-page.remove');

        Route::post('generate-sitemap', [\App\Http\Controllers\SitemapController::class, 'generate'])->name('sitemap.generate');

        // Notifications
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::get('notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
        Route::post('notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
        Route::post('notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
        Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

        // Software Development
        Route::get('software-development', [AdminSoftwareDevelopmentController::class, 'index'])->name('software-development');
        Route::get('software-development/content', [AdminSoftwareDevelopmentController::class, 'editContent'])->name('software-development.content');
        Route::put('software-development/content', [AdminSoftwareDevelopmentController::class, 'updateContent'])->name('software-development.content.update');
        Route::get('software-development/{softwareDevelopmentRequest}', [AdminSoftwareDevelopmentController::class, 'show'])->name('software-development.show');
        Route::post('software-development/{softwareDevelopmentRequest}/status', [AdminSoftwareDevelopmentController::class, 'updateStatus'])->name('software-development.status');
        Route::post('software-development/{softwareDevelopmentRequest}/notes', [AdminSoftwareDevelopmentController::class, 'updateNotes'])->name('software-development.notes');
        Route::delete('software-development/{softwareDevelopmentRequest}', [AdminSoftwareDevelopmentController::class, 'destroy'])->name('software-development.destroy');
    });
});

Route::prefix('auth')->name('customer.')->group(function () {
    Route::get('login', [CustomerAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [CustomerAuthController::class, 'login'])->name('login.submit');
    Route::get('register', [CustomerAuthController::class, 'showRegister'])->name('register');
    Route::post('register', [CustomerAuthController::class, 'register'])->name('register.submit');
    Route::post('logout', [CustomerAuthController::class, 'logout'])->name('logout');

    Route::get('forgot-password', [CustomerAuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [CustomerAuthController::class, 'sendResetLink'])->name('forgot-password.submit');
    Route::get('reset-password/{token}', [CustomerAuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('reset-password', [CustomerAuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware(\App\Http\Middleware\CustomerAuth::class)->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [CustomerDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [CustomerDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [CustomerDashboardController::class, 'updatePassword'])->name('profile.password');
    Route::get('/orders', [CustomerDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderNumber}', [CustomerDashboardController::class, 'orderDetail'])->name('orders.detail');
});

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/our-company', function () {
    return view('front.our-company');
})->name('our-company');

Route::get('/privacy-policy', function () {
    return view('front.privacy-policy');
})->name('privacy-policy');

Route::get('/terms-conditions', function () {
    return view('front.terms-conditions');
})->name('terms-conditions');

Route::get('/annual-returns', function () {
    return view('front.annual-returns');
})->name('annual-returns');

Route::get('/public-recognition', function () {
    return view('front.public-recognition');
})->name('public-recognition');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/category/{slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/shop/product/{slug}', [ShopController::class, 'product'])->name('shop.product');

Route::get('/robots.txt', function () {
    $sitemapUrl = url('/sitemap.xml');
    return response()->view('robots', compact('sitemapUrl'))->header('Content-Type', 'text/plain');
})->name('robots');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{slug}', [CartController::class, 'add'])->name('add');
    Route::put('/update/{itemKey}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{itemKey}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
    Route::delete('/remove-coupon', [CartController::class, 'removeCoupon'])->name('remove-coupon');
    Route::post('/set-shipping', [CartController::class, 'setShipping'])->name('set-shipping');
    Route::delete('/remove-shipping', [CartController::class, 'removeShipping'])->name('remove-shipping');
});

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{orderNumber}', [CheckoutController::class, 'success'])->name('success');
    Route::post('/create-payment-intent', [CheckoutController::class, 'createPaymentIntent'])->name('create-payment-intent');
});

Route::get('/software-development', [SoftwareDevelopmentController::class, 'index'])->name('software.development');
Route::post('/software-development', [SoftwareDevelopmentController::class, 'submit'])->name('software.development.submit');

Route::get('/custom-quote', function () {
    return view('front.custom-quote');
})->name('custom.quote');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handle'])->name('webhooks.stripe');