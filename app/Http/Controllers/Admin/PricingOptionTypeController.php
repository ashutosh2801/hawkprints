<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingOptionType;
use Illuminate\Http\Request;

class PricingOptionTypeController extends Controller
{
    public function index()
    {
        $types = PricingOptionType::orderBy('sort_order')->get();
        return view('admin.pricing-option-types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:pricing_option_types,name',
            'icon' => 'nullable|string|max:50',
        ]);

        $maxOrder = PricingOptionType::max('sort_order') ?? 0;
        
        PricingOptionType::create([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? null,
            'sort_order' => $maxOrder + 1,
            'is_active' => true,
        ]);

        return back()->with('success', 'Option type created.');
    }

    public function update(Request $request, $id)
    {
        $type = PricingOptionType::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:pricing_option_types,name,' . $id,
            'icon' => 'nullable|string|max:50',
        ]);

        $type->update([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? null,
        ]);

        return back()->with('success', 'Option type updated.');
    }

    public function destroy($id)
    {
        PricingOptionType::findOrFail($id)->delete();
        return back()->with('success', 'Option type deleted.');
    }

    public function toggleStatus($id)
    {
        $type = PricingOptionType::findOrFail($id);
        $type->update(['is_active' => !$type->is_active]);
        return back()->with('success', 'Status updated.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            PricingOptionType::where('id', $id)->update(['sort_order' => $index]);
        }
        return response()->json(['success' => true]);
    }
}