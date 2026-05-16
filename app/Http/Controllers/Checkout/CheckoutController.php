<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Setting;
use App\Services\CartService;
use App\Services\EmailService;
use App\Services\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $taxRate = floatval(Setting::get('tax_rate', '13'));
        $taxRateDisplay = $taxRate > 1 ? $taxRate : $taxRate * 100;
        $tax = $this->cartService->getTax();
        $total = $this->cartService->getTotal();

        $stripeService = new StripePaymentService();
        $stripeEnabled = $stripeService->isEnabled();
        $stripePublishableKey = $stripeService->getPublishableKey();
        $codEnabled = Setting::get('cod_enabled', '0') === '1';

        $shippingCost = $this->cartService->getShippingCost();

        return view('checkout.index', compact('cart', 'subtotal', 'tax', 'taxRateDisplay', 'total', 'shippingCost', 'stripeEnabled', 'stripePublishableKey', 'codEnabled'));
    }

    public function process(Request $request)
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string|max:100',
            'billing_province' => 'required|string|max:100',
            'billing_postal' => 'required|string|max:20',
            'billing_country' => 'required|string|max:100',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_province' => 'required|string|max:100',
            'shipping_postal' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'same_address' => 'nullable',
            'notes' => 'nullable|string',
            'create_account' => 'nullable',
            'payment_method' => 'nullable|string|in:cod,stripe',
        ];

        if ($request->boolean('create_account')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        if (!empty($request->create_account) && !empty($request->password)) {
            if (User::where('email', $request->customer_email)->exists()) {
                return back()->withErrors([
                    'customer_email' => 'An account with this email already exists. Please log in to link this order, or use a different email.',
                ])->withInput();
            }
        }

        $validated = $request->only([
            'customer_name',
            'customer_email',
            'customer_phone',
            'billing_address',
            'billing_city',
            'billing_province',
            'billing_postal',
            'billing_country',
            'shipping_address',
            'shipping_city',
            'shipping_province',
            'shipping_postal',
            'shipping_country',
            'same_address',
            'notes',
            'create_account',
            'password',
            'payment_method',
            'payment_intent_id',
        ]);

        if ($this->cartService->getCount() === 0) {
            return redirect()->route('shop')->with('error', 'Your cart is empty');
        }

        $subtotal = $this->cartService->getSubtotal();
        $discount = $this->cartService->getDiscount();
        $tax = $this->cartService->getTax();
        $shipping = $this->cartService->getShippingCost();
        $total = ($subtotal - $discount) + $tax + $shipping;

        $paymentMethod = $validated['payment_method'] ?? (!empty($validated['payment_intent_id']) ? 'stripe' : 'cod');

        if ($paymentMethod === 'stripe' && !empty($validated['payment_intent_id'])) {
            $stripeService = new StripePaymentService();
            $paymentIntent = $stripeService->retrievePaymentIntent($validated['payment_intent_id']);

            if (!$paymentIntent) {
                return back()->withErrors(['payment_intent_id' => 'Unable to verify payment. Please try again.'])->withInput();
            }

            if ($paymentIntent['status'] !== 'succeeded') {
                return back()->withErrors(['payment_intent_id' => 'Payment has not been completed. Please complete the payment before submitting.'])->withInput();
            }

            $expectedAmount = round($total, 2);
            if (round($paymentIntent['amount'], 2) != $expectedAmount) {
                return back()->withErrors(['payment_intent_id' => 'Payment amount does not match order total.'])->withInput();
            }
        }

        DB::beginTransaction();
        try {
            $cart = $this->cartService->getCart();
            $subtotal = $this->cartService->getSubtotal();
            $discount = $this->cartService->getDiscount();
            $tax = $this->cartService->getTax();
            $shipping = $this->cartService->getShippingCost();
            $total = ($subtotal - $discount) + $tax + $shipping;

            // Build billing address
            $billingParts = array_filter([
                $validated['billing_address'] ?? null,
                $validated['billing_city'] ?? null,
                $validated['billing_province'] ?? null,
                $validated['billing_postal'] ?? null,
                $validated['billing_country'] ?? null,
            ]);
            $billingAddress = implode(', ', $billingParts);

            // Build shipping address
            if (!empty($validated['same_address'])) {
                $shippingAddress = $billingAddress;
            } else {
                $shippingParts = array_filter([
                    $validated['shipping_address'] ?? null,
                    $validated['shipping_city'] ?? null,
                    $validated['shipping_province'] ?? null,
                    $validated['shipping_postal'] ?? null,
                    $validated['shipping_country'] ?? null,
                ]);
                $shippingAddress = implode(', ', $shippingParts);
            }

            // Create account if checkbox is checked and password provided and user not logged in
            $userId = auth()->check() ? auth()->id() : null;
            if (!auth()->check() && !empty($validated['create_account']) && !empty($validated['password'])) {
                $existingUser = User::where('email', $validated['customer_email'])->first();
                if (!$existingUser) {
                    $user = User::create([
                        'name' => $validated['customer_name'],
                        'email' => $validated['customer_email'],
                        'password' => Hash::make($validated['password']),
                        'is_admin' => false,
                    ]);
                    $userId = $user->id;
                    Auth::login($user);

                    AdminNotification::createNotification('signup', [
                        'name' => $user->name,
                        'email' => $user->email,
                        'source' => 'checkout',
                    ]);

                    try {
                        $emailService = new EmailService();
                        $emailService->sendTemplateEmail('welcome_email', $user->email, [
                            'customer_name' => $user->name,
                            'customer_email' => $user->email,
                            'registered_date' => now()->format('M j, Y'),
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('Welcome email failed: ' . $e->getMessage());
                    }
                }
            }

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'user_id' => $userId,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'billing_address' => $billingAddress ?: null,
                'shipping_address' => $shippingAddress ?: null,
                'notes' => $validated['notes'] ?? null,
                'payment_method' => $validated['payment_method'] ?? (!empty($validated['payment_intent_id']) ? 'stripe' : 'cod'),
                'payment_intent_id' => $validated['payment_intent_id'] ?? null,
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
                    'pricing_options' => $item['pricing_options'] ?? null,
                    'artwork_files' => $item['artwork_files'] ?? null,
                ]);
            }

            DB::commit();

            AdminNotification::createNotification('order', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'total' => $order->total,
            ]);

            $emailService = new EmailService();
            $emailService->sendOrderEmails($order);

            $this->cartService->clear();

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            logger('Checkout process error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    public function createPaymentIntent(Request $request)
    {
        $stripeService = new StripePaymentService();
        
        if (!$stripeService->isEnabled()) {
            return response()->json(['error' => 'Stripe not enabled'], 400);
        }

        if ($this->cartService->getCount() === 0) {
            return response()->json(['error' => 'Your cart is empty'], 400);
        }

        $total = $this->cartService->getTotal();
        $amount = round($total * 100);
        
        $result = $stripeService->createPaymentIntent($amount);
        
        if (!$result) {
            return response()->json(['error' => 'Failed to create payment intent'], 500);
        }

        return response()->json($result);
    }
}