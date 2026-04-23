<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class CheckoutController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        if ($this->cartService->getCount() === 0) {
            return redirect()->route('shop')->with('error', 'Your cart is empty');
        }

        $cart = $this->cartService->getCart();
        $subtotal = $this->cartService->getSubtotal();
        $tax = $this->cartService->getTax();
        $total = $this->cartService->getTotal();

        return view('checkout.index', compact('cart', 'subtotal', 'tax', 'total'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'billing_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($this->cartService->getCount() === 0) {
            return redirect()->route('shop')->with('error', 'Your cart is empty');
        }

        DB::beginTransaction();
        try {
            $cart = $this->cartService->getCart();
            $subtotal = $this->cartService->getSubtotal();
            $tax = $this->cartService->getTax();
            $shipping = 0;
            $total = $subtotal + $tax + $shipping;

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'billing_address' => $validated['billing_address'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant_id'] ?? null,
                    'product_name' => $item['name'],
                    'variant_name' => $item['variant_name'] ?? null,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            $this->cartService->clear();

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}
