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
        $total = $this->cartService->getTotal();

        return view('cart.index', compact('cart', 'subtotal', 'tax', 'total'));
    }

    public function add(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $quantity = $request->quantity ?? 1;

        $this->cartService->add($product, $quantity);

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

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
        ]);
    }
}
