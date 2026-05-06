@extends('admin.layout')

@section('page-title', 'Edit Product - ' . $product->name)

@section('content')
<div class="max-w-6xl">
    <div class="mb-6">
        <a href="/admin/products" class="text-blue-600 hover:underline">&larr; Back to Products</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="border-b">
            <nav class="flex -mb-px" aria-label="Tabs">
                <button onclick="switchTab('basic')" id="tab-basic" class="tab-btn py-4 px-6 border-b-2 border-blue-600 text-blue-600 font-medium text-sm">Basic Details</button>
                <button onclick="switchTab('pricing')" id="tab-pricing" class="tab-btn py-4 px-6 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">Pricing Options</button>
                <button onclick="switchTab('images')" id="tab-images" class="tab-btn py-4 px-6 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">Images</button>
            </nav>
        </div>

        <div class="p-6">
            <!-- Basic Details Tab -->
            <div id="panel-basic" class="tab-panel">
                <form action="/admin/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="name" value="{{ $product->name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                            <input type="text" name="sku" value="{{ $product->sku }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Base Price ($)</label>
                            <input type="number" name="base_price" step="0.01" value="{{ $product->base_price }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Status</label>
                            <select name="in_stock" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="1" {{ $product->in_stock ? 'selected' : '' }}>In Stock</option>
                                <option value="0" {{ !$product->in_stock ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg wysiwyg">{{ $product->description }}</textarea>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Featured Product</label>
                            <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="w-4 h-4">
                            <span class="ml-2 text-sm text-gray-600">Show on homepage</span>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Allow Artwork Upload</label>
                            <input type="checkbox" name="allow_artwork_upload" value="1" {{ $product->allow_artwork_upload ? 'checked' : '' }} class="w-4 h-4">
                            <span class="ml-2 text-sm text-gray-600">Allow customers to upload their artwork</span>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Artwork Instructions</label>
                            <textarea name="artwork_instructions" class="w-full px-4 py-2 border border-gray-300 rounded-lg wysiwyg" placeholder="Instructions for customers about artwork requirements">{{ $product->artwork_instructions ?? '' }}</textarea>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Basic Details</button>
                    </div>
                </form>
            </div>

            <!-- Pricing Options Tab -->
            <div id="panel-pricing" class="tab-panel hidden">
                <div class="mb-4">
                    <h4 class="text-lg font-medium">Current Pricing Options</h4>
                    <p class="text-sm text-gray-600">Manage pricing options - each option is a choice customer makes</p>
                </div>

                @forelse($pricingOptions as $opt)
                <div class="bg-gray-50 p-4 rounded-lg mb-4 border">
                    <form action="/admin/pricing-options/{{ $opt['id'] }}" method="POST" data-option-id="{{ $opt['id'] }}">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-5 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Option Name</label>
                                <input type="text" name="option_name" value="{{ $opt['option_name'] }}" required class="w-full px-3 py-2 text-sm border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Category</label>
                                <select name="option_type" class="w-full px-3 py-2 text-sm border rounded-lg">
                                    @foreach($pricingOptionTypes as $type)
                                    <option value="{{ $type->name }}" {{ isset($opt['option_type']) && $opt['option_type']==$type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Input Style</label>
                                <select name="input_type" class="w-full px-3 py-2 text-sm border rounded-lg">
                                    <option value="dropdown" {{ ($opt['input_type'] ?? 'dropdown') == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Required</label>
                                <input type="checkbox" name="is_required" value="1" {{ !empty($opt['is_required']) ? 'checked' : '' }} class="w-4 h-4 mt-2">
                            </div>
                            <div class="flex items-end gap-2">
                                <button type="submit" class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Update</button>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-xs font-medium text-gray-700 mb-2">Choices & Prices</label>
                            <div class="space-y-2" id="choices-container-{{ $opt['id'] }}">
                                @foreach(($opt['choices'] ?? []) as $index => $choice)
                                <div class="flex items-center gap-2 choice-row">
                                    <input type="text" name="choices[]" value="{{ $choice }}" placeholder="Choice" class="flex-1 px-3 py-2 text-sm border rounded-lg">
                                    <span class="text-gray-500">$</span>
                                    <input type="number" name="prices[]" step="0.01" value="{{ $opt['prices'][$index] ?? 0 }}" placeholder="Price" class="w-28 px-3 py-2 text-sm border rounded-lg">
                                    <button type="button" onclick="removeChoiceRow(this)" class="p-2 text-red-600 hover:bg-red-100 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addChoiceRow('{{ $opt['id'] }}')" class="mt-2 px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded">
                                + Add Choice
                            </button>
                            <input type="hidden" name="choices_text" id="choices-text-{{ $opt['id'] }}">
                            <input type="hidden" name="prices_text" id="prices-text-{{ $opt['id'] }}">
                        </div>
                        <div class="mt-4 border-t pt-4">
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-xs font-medium text-gray-700">Conditional Rules</label>
                                <span class="text-xs text-gray-500">When a choice is selected, change other options</span>
                            </div>
                            <div id="conditions-container-{{ $opt['id'] }}">
                                @foreach(($opt['conditions'] ?? []) as $condIndex => $cond)
                                @php
                                    $affectChoices = [];
                                    $affectPrices = [];
                                    foreach ($pricingOptionTypes as $t) {
                                        if ($t->name == ($cond['affects_option_type'] ?? '')) {
                                            $relatedOption = $product->pricingOptions->firstWhere('option_type', $t->name);
                                            if ($relatedOption) {
                                                $affectChoices = $relatedOption->choices ?? [];
                                                $affectPrices = $relatedOption->prices ?? [];
                                            }
                                            break;
                                        }
                                    }
                                    $existingHideChoices = $cond['hide_choices'] ?? [];
                                    $existingPriceModifiers = $cond['price_modifiers'] ?? [];
                                @endphp
                                <div class="bg-white p-3 rounded border mb-3 condition-row" data-condition-index="{{ $condIndex }}" data-affects-type="{{ $cond['affects_option_type'] ?? '' }}">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-xs text-gray-600 font-medium">When customer selects:</span>
                                        <select name="conditions[{{ $condIndex }}][when_choice_index]" class="condition-choice-select px-2 py-1 text-xs border rounded">
                                            @foreach(($opt['choices'] ?? []) as $ci => $cv)
                                            <option value="{{ $ci }}" {{ ($cond['when_choice_index'] ?? '') == $ci ? 'selected' : '' }}>{{ $cv }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-xs text-gray-600">→ affects option:</span>
                                        <select name="conditions[{{ $condIndex }}][affects_option_type]" class="condition-affects-select px-2 py-1 text-xs border rounded">
                                            <option value="">-- Select --</option>
                                            @foreach($pricingOptionTypes as $type)
                                            @if($type->name !== $opt['option_type'])
                                            <option value="{{ $type->name }}" {{ ($cond['affects_option_type'] ?? '') == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        <button type="button" onclick="this.closest('.condition-row').remove()" class="ml-auto text-xs text-red-600 hover:underline">Remove Rule</button>
                                    </div>
                                    <div class="ml-4 mt-3 hidden condition-details" id="condition-details-{{ $condIndex }}">
                                        <div class="mb-3">
                                            <label class="block text-xs text-gray-700 font-medium mb-1">Hide these choices (check to hide):</label>
                                            <div class="flex flex-wrap gap-3 hide-checkboxes">
                                                @foreach($affectChoices as $ai => $ac)
                                                <label class="inline-flex items-center gap-1 text-xs">
                                                    <input type="checkbox" name="conditions[{{ $condIndex }}][hide_choices_check][]" value="{{ $ai }}" {{ in_array($ai, $existingHideChoices) ? 'checked' : '' }} class="w-3 h-3 rounded">
                                                    {{ $ac }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-xs text-gray-700 font-medium mb-1">Override prices (check & set new price):</label>
                                            <div class="space-y-1">
                                                @foreach($affectChoices as $ai => $ac)
                                                @php
                                                    $hasPriceOverride = isset($existingPriceModifiers[$ai]) || isset($existingPriceModifiers[strval($ai)]);
                                                    $overridePrice = $existingPriceModifiers[$ai] ?? ($existingPriceModifiers[strval($ai)] ?? '');
                                                @endphp
                                                <div class="flex items-center gap-3">
                                                    <label class="inline-flex items-center gap-2 text-xs w-48">
                                                        <input type="checkbox" class="price-override-check w-3 h-3 rounded" data-condition="{{ $condIndex }}" data-choice="{{ $ai }}" {{ $hasPriceOverride ? 'checked' : '' }}>
                                                        <span class="font-medium">{{ $ac }}</span>
                                                    </label>
                                                    <span class="text-xs text-gray-500">Original: ${{ number_format($affectPrices[$ai] ?? 0, 2) }}</span>
                                                    <span class="text-gray-400">→</span>
                                                    <span class="text-gray-500">$</span>
                                                    <input type="number" step="0.01" name="conditions[{{ $condIndex }}][price_{{ $ai }}]" value="{{ $overridePrice }}" placeholder="0.00" class="w-24 px-2 py-1 text-xs border rounded price-override-input {{ $hasPriceOverride ? '' : 'bg-gray-50' }}" {{ $hasPriceOverride ? '' : 'disabled' }}>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addConditionRow('{{ $opt['id'] }}')" class="mt-2 px-3 py-1 text-xs text-purple-600 hover:bg-purple-50 rounded border border-purple-200">
                                + Add Conditional Rule
                            </button>
                            <input type="hidden" name="conditions_text" id="conditions-text-{{ $opt['id'] }}">
                        </div>
                    </form>
                    <form action="/admin/pricing-options/{{ $opt['id'] }}" method="POST" class="mt-3" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-lg">Delete</button>
                    </form>
                </div>
                @empty
                <div class="bg-gray-50 p-4 rounded-lg mb-4 text-gray-500 text-sm">No pricing options yet.</div>
                @endforelse

                <hr class="my-6">

                <h4 class="text-md font-medium mb-3">Add New Pricing Option</h4>
                <form action="/admin/products/{{ $product->id }}/pricing-options" method="POST" class="bg-blue-50 p-4 rounded-lg border">
                    @csrf
                    <div class="grid grid-cols-5 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Option Name</label>
                            <input type="text" name="option_name" required class="w-full px-3 py-2 text-sm border rounded-lg" placeholder="Select Quantity">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Category</label>
                            <select name="option_type" class="w-full px-3 py-2 text-sm border rounded-lg" required>
                                <option value="">-- Select --</option>
                                @foreach($pricingOptionTypes as $type)
                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1"><a href="/admin/pricing-option-types" class="text-blue-600">Manage</a></p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Input Style</label>
                            <select name="input_type" class="w-full px-3 py-2 text-sm border rounded-lg">
                                <option value="dropdown">Dropdown</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Required</label>
                            <input type="checkbox" name="is_required" value="1" checked class="w-4 h-4 mt-2">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white text-sm rounded-lg">Add</button>
                        </div>
                    </div>
                    <div class="mt-4">
                            <label class="block text-xs font-medium text-gray-700 mb-2">Choices & Prices</label>
                            <div class="space-y-2" id="new-choices-container">
                                <div class="flex items-center gap-2 choice-row">
                                    <input type="text" name="new_choices[]" placeholder="Choice (e.g., 500 qty)" class="flex-1 px-3 py-2 text-sm border rounded-lg">
                                    <span class="text-gray-500">$</span>
                                    <input type="number" name="new_prices[]" step="0.01" placeholder="Price" class="w-28 px-3 py-2 text-sm border rounded-lg">
                                    <button type="button" onclick="removeChoiceRow(this)" class="p-2 text-red-600 hover:bg-red-100 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>
                            <button type="button" onclick="addChoiceRow('new')" class="mt-2 px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded">
                                + Add Choice
                            </button>
                            <input type="hidden" name="choices_text" id="choices-text-new">
                            <input type="hidden" name="prices_text" id="prices-text-new">
                        </div>
                </form>
            </div>

            <!-- Images Tab -->
            <div id="panel-images" class="tab-panel hidden">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-medium">Product Images</h4>
                    <button onclick="openMediaLibrary({ mode: 'multiple', attachProductId: {{ $product->id }} })" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add from Library
                    </button>
                </div>

                <!-- Current Product Images -->
                <div class="grid grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-4" id="product-images-grid">
                    @forelse($productImages as $image)
                    <div class="group border rounded-lg overflow-hidden" data-image-id="{{ $image->id }}">
                        <div class="relative">
                            <img src="{{ $image->small ?: $image->image }}" alt="" class="w-full h-28 object-cover">
                            @if($image->is_primary)
                            <span class="absolute top-1 left-1 px-2 py-0.5 bg-yellow-400 text-xs font-medium rounded">Primary</span>
                            @endif
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                                @if(!$image->is_primary)
                                <button onclick="setPrimaryImage({{ $image->id }})" class="p-1.5 bg-white rounded shadow hover:bg-gray-100" title="Set as primary">
                                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                </button>
                                @endif
                                <button onclick="removeProductImage({{ $image->id }})" class="p-1.5 bg-white rounded shadow hover:bg-red-50" title="Remove">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="px-2 py-1.5 text-xs text-gray-500 bg-gray-50">#{{ $image->sort_order }}</div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center border-2 border-dashed border-gray-300 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-gray-500 font-medium">No images yet</p>
                        <button onclick="openMediaLibrary({ mode: 'multiple', attachProductId: {{ $product->id }} })" class="mt-2 text-blue-600 hover:underline text-sm">Add from Media Library</button>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const allOptionTypes = @json($pricingOptionTypes->pluck('name')->toArray());

function switchTab(tab) {
    const url = new URL(window.location.href);
    url.searchParams.set('tab', tab);
    history.replaceState(null, '', url.toString());
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('border-blue-600', 'text-blue-600');
        b.classList.add('border-transparent', 'text-gray-500');
    });
    document.getElementById('panel-' + tab).classList.remove('hidden');
    document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-500');
    document.getElementById('tab-' + tab).classList.add('border-blue-600', 'text-blue-600');
}

document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const activeTab = params.get('tab') || 'basic';
    switchTab(activeTab);

    document.querySelectorAll('.condition-row').forEach(row => {
        const affectsSelect = row.querySelector('.condition-affects-select');

        if (affectsSelect && affectsSelect.value) {
            const details = row.querySelector('.condition-details');
            if (details) {
                details.classList.remove('hidden');
            }
            attachPriceOverrideListeners(row);
        }

        if (affectsSelect) {
            affectsSelect.addEventListener('change', function() {
                const form = this.closest('form');
                const optionId = form.dataset.optionId;
                if (optionId) {
                    loadAffectedOptions(row, this.value, optionId);
                }
            });
        }
    });
});

function addConditionRow(optionId) {
    const container = document.getElementById('conditions-container-' + optionId);
    const index = container.querySelectorAll('.condition-row').length;
    const form = container.closest('form');
    const optId = form.dataset.optionId;
    const optionTypeSelect = form.querySelector('select[name="option_type"]');
    const currentOptionType = optionTypeSelect ? optionTypeSelect.value : '';

    const row = document.createElement('div');
    row.className = 'bg-white p-3 rounded border mb-3 condition-row';
    row.dataset.conditionIndex = index;

    let choiceOptions = '';
    const choicesContainer = document.getElementById('choices-container-' + optionId);
    if (choicesContainer) {
        choicesContainer.querySelectorAll('.choice-row').forEach((cr, ci) => {
            const choiceInput = cr.querySelector('input[name="choices[]"]');
            const label = choiceInput ? choiceInput.value : `Choice ${ci + 1}`;
            choiceOptions += `<option value="${ci}">${label}</option>`;
        });
    }

    let affectsOptions = '<option value="">-- Select --</option>';
    allOptionTypes.forEach(type => {
        if (type !== currentOptionType) {
            affectsOptions += `<option value="${type}">${type}</option>`;
        }
    });

    row.innerHTML = `
        <div class="flex items-center gap-3 mb-2">
            <span class="text-xs text-gray-600 font-medium">When customer selects:</span>
            <select name="conditions[${index}][when_choice_index]" class="condition-choice-select px-2 py-1 text-xs border rounded">${choiceOptions}</select>
            <span class="text-xs text-gray-600">→ affects option:</span>
            <select name="conditions[${index}][affects_option_type]" class="condition-affects-select px-2 py-1 text-xs border rounded">${affectsOptions}</select>
            <button type="button" onclick="this.closest('.condition-row').remove()" class="ml-auto text-xs text-red-600 hover:underline">Remove Rule</button>
        </div>
        <div class="ml-4 mt-3 hidden condition-details" id="condition-details-${index}">
            <div class="mb-3">
                <label class="block text-xs text-gray-700 font-medium mb-1">Hide these choices (check to hide):</label>
                <div class="flex flex-wrap gap-3 hide-checkboxes"></div>
            </div>
            <div class="mb-3">
                <label class="block text-xs text-gray-700 font-medium mb-1">Override prices (check & set new price):</label>
                <div class="space-y-1 price-overrides"></div>
            </div>
        </div>
    `;
    container.appendChild(row);

    const affectsSelect = row.querySelector('.condition-affects-select');
    affectsSelect.addEventListener('change', function() {
        if (optId) {
            loadAffectedOptions(row, this.value, optId);
        }
    });
}

function loadAffectedOptions(row, optionType, optionId) {
    console.log('loadAffectedOptions called:', { optionType, optionId });
    const details = row.querySelector('.condition-details');
    const hideContainer = row.querySelector('.hide-checkboxes');
    const priceContainer = row.querySelector('.price-overrides');
    const condIdx = row.dataset.conditionIndex;

    if (!optionType) {
        details.classList.add('hidden');
        return;
    }

    fetch(`/admin/pricing-options/choices/${optionId}/${optionType}`)
        .then(res => {
            console.log('Fetch response status:', res.status);
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(data => {
            console.log('Fetched data:', data);
            details.classList.remove('hidden');
            hideContainer.innerHTML = '';
            priceContainer.innerHTML = '';

            data.choices.forEach((choice, idx) => {
                const price = data.prices[idx] ?? 0;
                hideContainer.innerHTML += `
                    <label class="inline-flex items-center gap-1 text-xs">
                        <input type="checkbox" name="conditions[${condIdx}][hide_choices_check][]" value="${idx}" class="w-3 h-3 rounded">
                        ${choice}
                    </label>
                `;
                priceContainer.innerHTML += `
                    <div class="flex items-center gap-3">
                        <label class="inline-flex items-center gap-2 text-xs w-48">
                            <input type="checkbox" class="price-override-check w-3 h-3 rounded" data-condition="${condIdx}" data-choice="${idx}">
                            <span class="font-medium">${choice}</span>
                        </label>
                        <span class="text-xs text-gray-500">Original: $${parseFloat(price).toFixed(2)}</span>
                        <span class="text-gray-400">→</span>
                        <span class="text-gray-500">$</span>
                        <input type="number" step="0.01" name="conditions[${condIdx}][price_${idx}]" value="" placeholder="0.00" class="w-24 px-2 py-1 text-xs border rounded price-override-input bg-gray-50" disabled>
                    </div>
                `;
            });

            attachPriceOverrideListeners(row);
        })
        .catch(err => {
            console.error('Fetch error:', err);
            details.classList.add('hidden');
        });
}

function attachPriceOverrideListeners(row) {
    row.querySelectorAll('.price-override-check').forEach(check => {
        check.addEventListener('change', function() {
            const condIdx = this.dataset.condition;
            const choiceIdx = this.dataset.choice;
            const input = row.querySelector(`input[name="conditions[${condIdx}][price_${choiceIdx}]"]`);
            if (input) {
                input.disabled = !this.checked;
                input.classList.toggle('bg-gray-50', !this.checked);
                if (!this.checked) input.value = '';
            }
        });
    });
}

document.querySelectorAll('#panel-pricing form').forEach(form => {
    if (form.querySelector('input[name="choices_text"]')) {
        form.addEventListener('submit', function(e) {
            const choicesInput = this.querySelector('input[name="choices_text"]');
            const pricesInput = this.querySelector('input[name="prices_text"]');

            if (choicesInput && pricesInput) {
                const choices = [];
                const prices = [];
                this.querySelectorAll('.choice-row').forEach(row => {
                    const choiceInput = row.querySelector('input[name="choices[]"]');
                    const priceInput = row.querySelector('input[name="prices[]"]');
                    if (choiceInput && choiceInput.value.trim()) {
                        choices.push(choiceInput.value.trim());
                        prices.push(priceInput ? priceInput.value || '0' : '0');
                    }
                });
                choicesInput.value = choices.join(',');
                pricesInput.value = prices.join(',');
            }
        });
    }
});
</script>

@include('admin.partials.media-library')

@endsection