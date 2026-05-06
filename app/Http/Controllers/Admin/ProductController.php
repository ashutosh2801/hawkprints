<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\PricingOption;
use App\Models\PricingOptionType;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        
        $products = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = Category::where('is_active', true)->get();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'sku' => 'nullable|string',
            'base_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'in_stock' => 'nullable|boolean',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($request->name);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['in_stock'] = $request->boolean('in_stock', true);
        $validated['is_active'] = true;
        $validated['allow_artwork_upload'] = $request->boolean('allow_artwork_upload', true);
        $validated['artwork_instructions'] = $request->artwork_instructions;

        if ($request->image_url) {
            $validated['image'] = $request->image_url;
        }

        $product = Product::create($validated);

        return redirect('/admin/products/' . $product->id . '/edit')
            ->with('success', 'Product created.');
    }

public function edit($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect('/admin/products')->with('error', 'Product not found');
        }
        
        $categories = Category::where('is_active', true)->get();
        $productImages = ProductImage::where('product_id', $id)->orderBy('sort_order')->get();
        $pricingOptionTypes = PricingOptionType::where('is_active', true)->orderBy('sort_order')->get();
        
        $opts = PricingOption::where('product_id', $id)->orderBy('sort_order')->get();
        $pricingOptions = $opts->toArray();
        
        return view('admin.products.edit', compact('product', 'categories', 'productImages', 'pricingOptions', 'pricingOptionTypes'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return back()->with('error', 'Product not found');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'sku' => 'nullable|string',
            'base_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'in_stock' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['in_stock'] = $request->boolean('in_stock', true);
        $validated['allow_artwork_upload'] = $request->boolean('allow_artwork_upload', true);
        $validated['artwork_instructions'] = $request->artwork_instructions;

        if ($request->image_url) {
            $validated['image'] = $request->image_url;
        }

        $product->update($validated);

        return back()->with('success', 'Product updated.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
        }
        return redirect('/admin/products')->with('success', 'Product deleted.');
    }

    public function addPricingOption(Request $request, Product $product)
    {
        if (!$product || !$product->id) {
            return back()->with('error', 'Invalid product.');
        }
        
        $choiceName = $request->input('new_choices');
        $hasChoice = false;
        
        if (is_array($choiceName)) {
            foreach ($choiceName as $c) {
                if (!empty(trim($c))) {
                    $hasChoice = true;
                    break;
                }
            }
        }
        
        if (!$hasChoice) {
            return back()->with('error', 'Please add at least one choice.');
        }

        $choicesRaw = is_array($request->input('new_choices')) ? $request->input('new_choices') : [];
        $pricesRaw = is_array($request->input('new_prices')) ? $request->input('new_prices') : [];
        
        $choices = [];
        $prices = [];
        
        foreach ($choicesRaw as $index => $choice) {
            if (!empty(trim($choice))) {
                $choices[] = trim($choice);
                $prices[] = isset($pricesRaw[$index]) ? floatval($pricesRaw[$index] ?? 0) : 0;
            }
        }

        $pricingOption = new PricingOption([
            'option_name' => $request->input('option_name'),
            'option_type' => $request->input('option_type'),
            'input_type' => $request->input('input_type'),
            'choices' => array_values($choices),
            'prices' => array_values($prices),
            'is_required' => $request->boolean('is_required', true),
            'sort_order' => ($product->pricingOptions()->max('sort_order') ?? 0) + 1,
        ]);
        
        $pricingOption->product()->associate($product);
        $pricingOption->save();

        return back()->with('success', 'Pricing option added.');
    }

    public function updatePricingOption(Request $request, PricingOption $option)
    {
        $request->validate([
            'option_name' => 'required|string|max:255',
            'option_type' => 'required|string|max:50',
            'input_type' => 'required|in:dropdown',
            'choices_text' => 'nullable|string',
            'prices_text' => 'nullable|string',
        ]);

        $choices = array_filter(array_map('trim', explode(',', $request->choices_text ?? '')));
        $prices = array_filter(array_map('trim', explode(',', $request->prices_text ?? '')));

        $conditions = [];
        if ($request->has('conditions')) {
            foreach ($request->conditions as $cond) {
                if (!empty($cond['affects_option_type']) && isset($cond['when_choice_index'])) {
                    $priceModifiers = [];
                    foreach ($cond as $key => $value) {
                        if (str_starts_with($key, 'price_') && !empty($value)) {
                            $choiceIdx = str_replace('price_', '', $key);
                            $priceModifiers[$choiceIdx] = floatval($value);
                        }
                    }
                    $conditions[] = [
                        'when_choice_index' => intval($cond['when_choice_index']),
                        'affects_option_type' => $cond['affects_option_type'],
                        'hide_choices' => isset($cond['hide_choices_check']) ? array_filter(array_map('intval', $cond['hide_choices_check'])) : [],
                        'price_modifiers' => $priceModifiers,
                    ];
                }
            }
        }

        $option->update([
            'option_name' => $request->option_name,
            'option_type' => $request->option_type,
            'input_type' => $request->input_type,
            'choices' => array_values($choices),
            'prices' => array_values($prices),
            'conditions' => $conditions,
            'is_required' => $request->boolean('is_required', true),
        ]);

        return back()->with('success', 'Pricing option updated.');
    }

    public function deletePricingOption(PricingOption $option)
    {
        $option->delete();
        return back()->with('success', 'Pricing option deleted.');
    }

    public function getAffectedOptionChoices($pricingOptionId, $optionType)
    {
        $pricingOption = PricingOption::with('product')->findOrFail($pricingOptionId);
        $product = $pricingOption->product;
        $relatedOption = $product->pricingOptions()->where('option_type', $optionType)->first();

        if (!$relatedOption) {
            return response()->json(['choices' => [], 'prices' => []]);
        }

        return response()->json([
            'choices' => $relatedOption->choices ?? [],
            'prices' => $relatedOption->prices ?? [],
        ]);
    }
}