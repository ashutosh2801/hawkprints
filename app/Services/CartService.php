<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $cartKey = 'cart';

    public function __construct()
    {
        if (!Session::has($this->cartKey)) {
            Session::put($this->cartKey, []);
        }
    }

    public function getCart(): array
    {
        return Session::get($this->cartKey, []);
    }

    public function add(Product $product, int $quantity = 1, ?ProductVariant $variant = null): bool
    {
        $availableStock = $variant 
            ? ($variant->stock_quantity ?? PHP_INT_MAX)
            : ($product->stock_quantity ?? PHP_INT_MAX);

        $cart = $this->getCart();
        $itemKey = $product->id . ($variant ? '_' . $variant->id : '');

        $existingQty = isset($cart[$itemKey]) ? $cart[$itemKey]['quantity'] : 0;
        if ($existingQty + $quantity > $availableStock) {
            return false;
        }

        $price = $variant ? $variant->price : $product->price;

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += $quantity;
        } else {
            $cart[$itemKey] = [
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'name' => $product->name,
                'variant_name' => $variant?->name,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $product->primary_image,
            ];
        }

        Session::put($this->cartKey, $cart);
        return true;
    }

    public function update(string $itemKey, int $quantity): void
    {
        $cart = $this->getCart();

        if (isset($cart[$itemKey])) {
            if ($quantity <= 0) {
                unset($cart[$itemKey]);
            } else {
                $cart[$itemKey]['quantity'] = $quantity;
            }
            Session::put($this->cartKey, $cart);
        }
    }

    public function remove(string $itemKey): void
    {
        $cart = $this->getCart();
        unset($cart[$itemKey]);
        Session::put($this->cartKey, $cart);
    }

    public function clear(): void
    {
        Session::put($this->cartKey, []);
    }

    public function getSubtotal(): float
    {
        $subtotal = 0;
        foreach ($this->getCart() as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }

    public function getTax(float $taxRate = 0.13): float
    {
        return $this->getSubtotal() * $taxRate;
    }

    public function getTotal(float $shipping = 0, float $taxRate = 0.13): float
    {
        return $this->getSubtotal() + $this->getTax($taxRate) + $shipping;
    }

    public function getFormattedSubtotal(): string
    {
        return '$' . number_format($this->getSubtotal(), 2);
    }

    public function getCount(): int
    {
        $count = 0;
        foreach ($this->getCart() as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    public function getFormattedTotal(float $shipping = 0, float $taxRate = 0.13): string
    {
        return '$' . number_format($this->getTotal($shipping, $taxRate), 2);
    }
}