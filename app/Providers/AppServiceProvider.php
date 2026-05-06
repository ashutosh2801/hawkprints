<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\CartService;
use App\Models\MenuItem;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CartService::class, function ($app) {
            return new CartService();
        });
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $cartService = app(CartService::class);
            $view->with('cartCount', $cartService->getCount());
            
            $menuItems = MenuItem::getMenuItems();
            $view->with('menuItems', $menuItems);
        });
        
        \Illuminate\Support\Facades\Validator::extend('arrayable', function ($attribute, $value, $parameters, $validator) {
            return is_array($value);
        });
    }
}
