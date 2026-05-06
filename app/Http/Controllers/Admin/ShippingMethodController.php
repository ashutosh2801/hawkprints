<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $methods = ShippingMethod::orderBy('sort_order')->get();
        return view('admin.shipping-methods.index', compact('methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:shipping_methods,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'estimated_days' => 'nullable|string|max:255',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_order_amount' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        ShippingMethod::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'estimated_days' => $request->estimated_days,
            'is_active' => $request->boolean('is_active', true),
            'min_order_amount' => $request->min_order_amount,
            'max_order_amount' => $request->max_order_amount,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'Shipping method created successfully.');
    }

    public function update(Request $request, ShippingMethod $shippingMethod)
    {
        $request->validate([
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'estimated_days' => 'nullable|string|max:255',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_order_amount' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $shippingMethod->update([
            'description' => $request->description,
            'price' => $request->price,
            'estimated_days' => $request->estimated_days,
            'is_active' => $request->boolean('is_active', true),
            'min_order_amount' => $request->min_order_amount,
            'max_order_amount' => $request->max_order_amount,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'Shipping method updated successfully.');
    }

    public function toggle(ShippingMethod $shippingMethod)
    {
        $shippingMethod->update(['is_active' => !$shippingMethod->is_active]);
        return back()->with('success', 'Shipping method status updated.');
    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        $shippingMethod->delete();
        return back()->with('success', 'Shipping method deleted successfully.');
    }
}