<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        $subtotal = $this->cartService->getSubtotal();
        $tax = $this->cartService->getTax();
        $discount = $this->cartService->getDiscount();
        $shippingCost = $this->cartService->getShippingCost();
        $selectedShipping = $this->cartService->getShippingMethod();
        $total = $this->cartService->getTotal();
        $coupon = $this->cartService->getCoupon();
        $shippingMethods = $this->cartService->getAvailableShippingMethods();

        return view('cart.index', compact('cart', 'subtotal', 'tax', 'discount', 'shippingCost', 'selectedShipping', 'total', 'coupon', 'shippingMethods'));
    }

    public function add(Request $request, $slug)
    {
        $request->validate([
            'artwork_file' => 'nullable|array|max:5',
            'artwork_file.*' => 'nullable|file|mimes:pdf,ai,psd,png,jpg,jpeg|max:25600',
        ]);

        $product = Product::where('slug', $slug)->firstOrFail();
        $quantity = $request->quantity ?? 1;

        $pricingOptions = [];
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'option_')) {
                $optionId = str_replace('option_', '', $key);
                $pricingOptions[$optionId] = $value;
            }
        }

        $artworkFiles = [];
        if ($request->hasFile('artwork_file')) {
            foreach ($request->file('artwork_file') as $file) {
                $path = $file->store('artwork', 'public');
                $artworkFiles[] = $path;
            }
        }

        $added = $this->cartService->add($product, $quantity, null, $pricingOptions, $artworkFiles);

        if (!$added) {
            return back()->with('error', 'Not enough stock available.');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => $this->cartService->getCount(),
            ]);
        }

        return redirect('/cart')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $itemKey): JsonResponse
    {
        $quantity = (int) $request->quantity;
        $this->cartService->update($itemKey, $quantity);

        return response()->json([
            'success' => true,
            'cart_count' => $this->cartService->getCount(),
            'subtotal' => $this->cartService->getFormattedSubtotal(),
            'total' => $this->cartService->getFormattedTotal(),
        ]);
    }

    public function remove($itemKey): JsonResponse
    {
        $this->cartService->remove($itemKey);

        return response()->json([
            'success' => true,
            'cart_count' => $this->cartService->getCount(),
            'subtotal' => $this->cartService->getFormattedSubtotal(),
            'total' => $this->cartService->getFormattedTotal(),
        ]);
    }

    public function clear(): JsonResponse
    {
        $this->cartService->clear();
        $this->cartService->removeCoupon();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
        ]);
    }

    public function applyCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $result = $this->cartService->applyCoupon($request->code);

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message'],
            'code' => $result['code'],
            'discount' => $this->cartService->getDiscount(),
            'formatted_discount' => $this->cartService->getFormattedDiscount(),
            'subtotal' => $this->cartService->getSubtotal(),
            'tax' => $this->cartService->getTax(),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    public function removeCoupon(): JsonResponse
    {
        $this->cartService->removeCoupon();

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed',
            'subtotal' => $this->cartService->getSubtotal(),
            'tax' => $this->cartService->getTax(),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    public function setShipping(Request $request): JsonResponse
    {
        $request->validate([
            'method' => 'required|string',
        ]);

        $result = $this->cartService->setShippingMethod($request->method);

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message'],
            'method' => $result['method'],
            'price' => $result['price'],
            'shipping_cost' => $this->cartService->getShippingCost(),
            'subtotal' => $this->cartService->getSubtotal(),
            'tax' => $this->cartService->getTax(),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    public function removeShipping(): JsonResponse
    {
        $this->cartService->removeShippingMethod();

        return response()->json([
            'success' => true,
            'message' => 'Shipping method removed',
            'subtotal' => $this->cartService->getSubtotal(),
            'tax' => $this->cartService->getTax(),
            'total' => $this->cartService->getTotal(),
        ]);
    }
}
