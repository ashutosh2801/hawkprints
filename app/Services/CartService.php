<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $cartKey = 'cart';
    protected string $couponKey = 'cart_coupon';
    protected string $shippingKey = 'cart_shipping';

    public function __construct()
    {
        if (!Session::has($this->cartKey)) {
            Session::put($this->cartKey, []);
        }
    }

    public function setShippingMethod(?string $methodCode): array
    {
        $shippingMethod = ShippingMethod::where('name', $methodCode)->active()->first();
        
        if (!$shippingMethod) {
            return ['success' => false, 'message' => 'Invalid shipping method'];
        }
        
        $subtotal = $this->getSubtotal();
        if (!$shippingMethod->isAvailableForAmount($subtotal)) {
            return ['success' => false, 'message' => 'This shipping method is not available for your order amount'];
        }
        
        Session::put($this->shippingKey, $shippingMethod->name);
        
        return [
            'success' => true,
            'message' => 'Shipping method selected',
            'method' => $shippingMethod->name,
            'price' => $shippingMethod->price,
        ];
    }

    public function removeShippingMethod(): void
    {
        Session::forget($this->shippingKey);
    }

    public function getShippingMethod(): ?ShippingMethod
    {
        $name = Session::get($this->shippingKey);
        if (!$name) {
            return null;
        }
        return ShippingMethod::where('name', $name)->first();
    }

    public function getShippingCost(): float
    {
        $method = $this->getShippingMethod();
        if (!$method) {
            return 0;
        }
        return $method->price;
    }

    public function getAvailableShippingMethods(): array
    {
        $subtotal = $this->getSubtotal();
        return ShippingMethod::active()
            ->orderBy('sort_order')
            ->get()
            ->filter(function ($method) use ($subtotal) {
                return $method->isAvailableForAmount($subtotal);
            })
            ->values()
            ->toArray();
    }

    public function applyCoupon(string $code): array
    {
        $coupon = Coupon::where('code', strtoupper($code))
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('max_uses')->orWhere('uses', '<', \DB::raw('max_uses'));
            })
            ->first();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Invalid coupon code'];
        }

        if (!$coupon->isValid()) {
            return ['success' => false, 'message' => 'This coupon has expired or is no longer valid'];
        }

        $subtotal = $this->getSubtotal();
        if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
            return ['success' => false, 'message' => 'Minimum order amount of $' . number_format($coupon->min_order_amount, 2) . ' required'];
        }

        $affected = Coupon::where('id', $coupon->id)
            ->where(function ($query) {
                $query->whereNull('max_uses')->orWhere('uses', '<', \DB::raw('max_uses'));
            })
            ->increment('uses');

        if (!$affected) {
            return ['success' => false, 'message' => 'This coupon has reached its usage limit'];
        }

        Session::put($this->couponKey, $coupon->code);

        return [
            'success' => true,
            'message' => 'Coupon applied successfully',
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ];
    }

    public function removeCoupon(): void
    {
        Session::forget($this->couponKey);
    }

    public function getCoupon(): ?Coupon
    {
        $code = Session::get($this->couponKey);
        if (!$code) {
            return null;
        }
        return Coupon::where('code', $code)->first();
    }

    public function getDiscount(): float
    {
        $coupon = $this->getCoupon();
        if (!$coupon) {
            return 0;
        }
        return $coupon->calculateDiscount($this->getSubtotal());
    }

    public function getFormattedDiscount(): string
    {
        return '-$' . number_format($this->getDiscount(), 2);
    }

    public function getCart(): array
    {
        return Session::get($this->cartKey, []);
    }

    public function add(Product $product, int $quantity = 1, ?ProductVariant $variant = null, array $pricingOptions = [], array $artworkFiles = []): bool
    {
        $availableStock = $variant 
            ? ($variant->stock_quantity ?? PHP_INT_MAX)
            : ($product->stock_quantity ?? PHP_INT_MAX);

        $cart = $this->getCart();

        $basePrice = $variant ? $variant->price : ($product->base_price ?? 0);
        $price = $this->calculatePriceWithOptions($basePrice, $pricingOptions, $product);

        $itemKey = $this->generateItemKey($product, $variant, $pricingOptions);

        $existingQty = isset($cart[$itemKey]) ? $cart[$itemKey]['quantity'] : 0;
        if ($existingQty + $quantity > $availableStock) {
            return false;
        }

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += $quantity;
            if (!empty($artworkFiles)) {
                $cart[$itemKey]['artwork_files'] = array_merge($cart[$itemKey]['artwork_files'] ?? [], $artworkFiles);
            }
        } else {
            $cart[$itemKey] = [
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'name' => $product->name,
                'variant_name' => $variant?->name,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $product->primary_image,
                'pricing_options' => $pricingOptions,
                'artwork_files' => $artworkFiles,
            ];
        }

        Session::put($this->cartKey, $cart);
        return true;
    }

    protected function calculatePriceWithOptions(float $basePrice, array $pricingOptions, Product $product): float
    {
        $totalPrice = $basePrice;

        $optionIds = array_keys($pricingOptions);
        $options = \App\Models\PricingOption::whereIn('id', $optionIds)->get()->keyBy('id');

        foreach ($pricingOptions as $optionId => $selectedIndex) {
            $option = $options->get($optionId);
            if ($option) {
                if (is_array($selectedIndex)) {
                    foreach ($selectedIndex as $idx) {
                        if (isset($option->prices[$idx])) {
                            $totalPrice += floatval($option->prices[$idx]);
                        }
                    }
                } elseif (isset($option->prices[$selectedIndex])) {
                    $totalPrice += floatval($option->prices[$selectedIndex]);
                }
            }
        }

        return $totalPrice;
    }

    protected function generateItemKey(Product $product, ?ProductVariant $variant, array $pricingOptions): string
    {
        $key = $product->id . ($variant ? '_' . $variant->id : '');

        ksort($pricingOptions);
        foreach ($pricingOptions as $optionId => $value) {
            $serialized = is_array($value) ? implode(',', $value) : $value;
            $key .= '_' . $optionId . '=' . $serialized;
        }

        return $key;
    }

    public function getFormattedPricingOptions(array $pricingOptions): array
    {
        $formatted = [];

        $optionIds = array_keys($pricingOptions);
        $options = \App\Models\PricingOption::whereIn('id', $optionIds)->get()->keyBy('id');

        foreach ($pricingOptions as $optionId => $selectedIndex) {
            $option = $options->get($optionId);
            if ($option) {
                if (is_array($selectedIndex)) {
                    $choices = [];
                    foreach ($selectedIndex as $idx) {
                        $choice = $option->getChoiceByIndex($idx);
                        if ($choice) {
                            $choices[] = $choice;
                        }
                    }
                    if (!empty($choices)) {
                        $formatted[] = $option->option_name . ': ' . implode(', ', $choices);
                    }
                } else {
                    $choice = $option->getChoiceByIndex($selectedIndex);
                    if ($choice) {
                        $formatted[] = $option->option_name . ': ' . $choice;
                    }
                }
            }
        }

        return $formatted;
    }

    public static function getFormattedPricingOptionsFromItem(array $pricingOptions): array
    {
        return (new self())->getFormattedPricingOptions($pricingOptions);
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

    public function getTax(?float $taxRate = null): float
    {
        if ($taxRate === null) {
            $taxRate = floatval(\App\Models\Setting::get('tax_rate', '0.13'));
        }
        return ($this->getSubtotal() - $this->getDiscount()) * $taxRate;
    }

    public function getTotal(?float $shipping = null, ?float $taxRate = null): float
    {
        $shippingCost = $shipping ?? $this->getShippingCost();
        return ($this->getSubtotal() - $this->getDiscount()) + $this->getTax($taxRate) + $shippingCost;
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