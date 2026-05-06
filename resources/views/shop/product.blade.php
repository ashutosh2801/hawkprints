@extends('layouts.app')

@section('title', $product->name . ' - Hawk Prints')
@section('meta_description', $product->short_description ?? $product->meta_description)

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <nav class="mb-6 text-sm">
            <ol class="flex items-center gap-2 text-gray-600">
                <li><a href="/" class="hover:text-blue-700">Home</a></li>
                <li>/</li>
                <li><a href="/shop" class="hover:text-blue-700">Shop</a></li>
                @if($product->category)
                <li>/</li>
                <li><a href="/shop/category/{{ $product->category->slug }}" class="hover:text-blue-700">{{ $product->category->name }}</a></li>
                @endif
                <li>/</li>
                <li>{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-lg p-6 lg:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Column 1: Images -->
                <div class="lg:col-span-4">
                    <div class="space-y-4">
                        <div class="relative overflow-hidden rounded-lg bg-gray-100 cursor-zoom-in" id="mainImageContainer">
                            <div id="zoomStage" class="w-full aspect-square overflow-hidden">
                                <img src="{{ $product->primary_image }}"
                                     alt="{{ $product->name }}"
                                     id="mainImage"
                                     class="w-full h-full object-cover transition-transform duration-100">
                            </div>
                        </div>

                        @if($product->productImages->count() > 0)
                        <div class="relative">
                            <div class="flex gap-3 overflow-x-auto pb-2" id="thumbnailSlider">
                                <button onclick="changeMainImage('{{ $product->primary_image }}', event)"
                                        class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-blue-500 hover:border-blue-700 transition">
                                    <img src="{{ $product->primary_image }}" alt="Primary" class="w-full h-full object-cover">
                                </button>
                                @foreach($product->productImages as $image)
                                <button onclick="changeMainImage('{{ $image->image }}', event)"
                                        class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-gray-200 hover:border-blue-500 transition">
                                    <img src="{{ $image->image }}" alt="Gallery" class="w-full h-full object-cover">
                                </button>
                                @endforeach
                            </div>
                            <button id="thumbPrev" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 w-8 h-8 bg-white shadow rounded-full flex items-center justify-center hover:bg-gray-100 z-10">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button id="thumbNext" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 w-8 h-8 bg-white shadow rounded-full flex items-center justify-center hover:bg-gray-100 z-10">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Column 2: Title & Category -->
                <div class="lg:col-span-5">
                    <div class="">
                        @if($product->category)
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-full mb-3">{{ $product->category->name }}</span>
                        @endif
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                        <p class="text-gray-600 mb-6">{{ $product->short_description }}</p>

                        @if($product->sku)
                            <p class="text-sm text-gray-500 mb-4">SKU: {{ $product->sku }}</p>
                        @endif

                        @if($product->description)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-3">Product Details</h3>
                            <div class="text-gray-600 text-sm prose prose-sm max-w-none">
                                {!! $product->description !!}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Column 3: Pricing & Add to Cart -->
                <div class="lg:col-span-3">

                    @if($product->pricingOptions->count() > 0)
                    <form action="/cart/add/{{ $product->slug }}" method="POST" id="pricingForm" enctype="multipart/form-data">
                        @csrf

                        <div id="pricingOptions" class="space-y-4">
                            @foreach($product->pricingOptions as $option)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $option->option_name }}
                                    @if($option->is_required)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>

                                @if($option->input_type === 'radio')
                                    <div class="flex flex-wrap gap-2" data-option-type="{{ $option->option_type }}">
                                        @foreach($option->choices as $index => $choice)
                                        <label class="relative">
                                            <input type="radio"
                                                   name="option_{{ $option->id }}"
                                                   value="{{ $index }}"
                                                   class="peer sr-only"
                                                   data-option-id="{{ $option->id }}"
                                                   data-option-price="{{ $option->prices[$index] ?? 0 }}"
                                                   @if($index === 0) checked @endif
                                                   {{ $option->is_required ? 'required' : '' }}>
                                            <div class="px-4 py-2 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-700 peer-checked:bg-blue-50 hover:border-gray-300 transition">
                                                <span class="font-medium">{{ $choice }}</span>
                                                @if(isset($option->prices[$index]) && $option->prices[$index] > 0)
                                                <span class="text-sm text-gray-500 ml-1 price-label">+${{ number_format($option->prices[$index], 2) }}</span>
                                                @endif
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                @elseif($option->input_type === 'checkbox')
                                    <div class="flex flex-wrap gap-2" data-option-type="{{ $option->option_type }}">
                                        @foreach($option->choices as $index => $choice)
                                        <label class="relative">
                                            <input type="checkbox"
                                                   name="option_{{ $option->id }}[]"
                                                   value="{{ $index }}"
                                                   class="peer sr-only checkbox-option"
                                                   data-option-id="{{ $option->id }}"
                                                   data-option-price="{{ $option->prices[$index] ?? 0 }}">
                                            <div class="px-4 py-2 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-700 peer-checked:bg-blue-50 hover:border-gray-300 transition">
                                                <span class="font-medium">{{ $choice }}</span>
                                                @if(isset($option->prices[$index]) && $option->prices[$index] > 0)
                                                <span class="text-sm text-gray-500 ml-1 price-label">+${{ number_format($option->prices[$index], 2) }}</span>
                                                @endif
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                @else
                                    <select name="option_{{ $option->id }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                            data-option-id="{{ $option->id }}"
                                            data-option-type="{{ $option->option_type }}"
                                            {{ $option->is_required ? 'required' : '' }}>
                                        @foreach($option->choices as $index => $choice)
                                        <option value="{{ $index }}"
                                                data-option-price="{{ $option->prices[$index] ?? 0 }}">
                                            {{ $choice }}
                                            @if(isset($option->prices[$index]) && $option->prices[$index] > 0)
                                                (+${{ number_format($option->prices[$index], 2) }})
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        @include('shop.partials.artwork-upload')

                        <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-medium text-gray-700">Total Price:</span>
                                <span id="totalPrice" class="text-3xl font-bold text-blue-700">${{ number_format($product->base_price ?? 0, 2) }}</span>
                            </div>

                            <div class="flex items-center gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                                </div>
                                <button type="submit" class="flex-1 py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="mb-6">
                        <span class="text-3xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
                    </div>

                    <form action="/cart/add/{{ $product->slug }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @include('shop.partials.artwork-upload')

                        <div class="flex items-center gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                <input type="number" name="quantity" value="1" min="1" class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                            </div>
                            <button type="submit" class="flex-1 py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold">
                                Add to Cart
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <a href="/shop/product/{{ $related->slug }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ $related->primary_image }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">{{ $related->name }}</h3>
                        <p class="text-lg font-bold text-gray-900">{{ $related->formatted_price }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainImageContainer = document.getElementById('mainImageContainer');
    const mainImage = document.getElementById('mainImage');
    const zoomStage = document.getElementById('zoomStage');
    const thumbnailSlider = document.getElementById('thumbnailSlider');
    const thumbPrev = document.getElementById('thumbPrev');
    const thumbNext = document.getElementById('thumbNext');

    window.changeMainImage = function(src, evt) {
        mainImage.style.opacity = '0';
        mainImage.style.transform = 'scale(1)';
        setTimeout(() => {
            mainImage.src = src;
            mainImage.style.opacity = '1';
        }, 100);
        document.querySelectorAll('#thumbnailSlider button').forEach(btn => {
            btn.classList.remove('border-blue-500');
            btn.classList.add('border-gray-200');
        });
        if (evt && evt.currentTarget) {
            evt.currentTarget.classList.remove('border-gray-200');
            evt.currentTarget.classList.add('border-blue-500');
        }
    };

    if (thumbnailSlider) {
        thumbPrev.addEventListener('click', () => thumbnailSlider.scrollBy({ left: -100, behavior: 'smooth' }));
        thumbNext.addEventListener('click', () => thumbnailSlider.scrollBy({ left: 100, behavior: 'smooth' }));
    }

    if (mainImageContainer && mainImage) {
        let isZooming = false;

        mainImageContainer.addEventListener('mouseenter', function(e) {
            isZooming = true;
            mainImage.style.transition = 'transform 0.1s ease-out';
        });

        mainImageContainer.addEventListener('mousemove', function(e) {
            if (!isZooming) return;

            const rect = zoomStage.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const percentX = (x / rect.width) * 100;
            const percentY = (y / rect.height) * 100;

            const scale = 2;
            const translateX = -(percentX - 50) * (scale - 1);
            const translateY = -(percentY - 50) * (scale - 1);

            mainImage.style.transform = `scale(${scale}) translate(${translateX}%, ${translateY}%)`;
        });

        mainImageContainer.addEventListener('mouseleave', function() {
            isZooming = false;
            mainImage.style.transform = 'scale(1)';
            mainImage.style.transition = 'transform 0.3s ease-out, opacity 0.1s ease-out';
        });
    }
});
</script>
@if($product->pricingOptions->count() > 0)
@php
$conditionsArray = [];
foreach ($product->pricingOptions as $opt) {
    foreach (($opt->conditions ?? []) as $cond) {
        $conditionsArray[] = [
            'source_option_id' => $opt->id,
            'source_option_type' => $opt->option_type,
            'when_choice_index' => $cond['when_choice_index'] ?? 0,
            'affects_option_type' => $cond['affects_option_type'] ?? '',
            'hide_choices' => $cond['hide_choices'] ?? [],
            'price_modifiers' => $cond['price_modifiers'] ?? [],
        ];
    }
}
@endphp
<script>
document.addEventListener('DOMContentLoaded', function() {
    const basePrice = {{ $product->base_price ?? 0 }};
    const quantityInput = document.getElementById('quantity');
    const totalPriceEl = document.getElementById('totalPrice');

    const conditionsData = @json($conditionsArray);

    const optionsByType = {};
    @foreach($product->pricingOptions as $opt)
    optionsByType['{{ $opt->option_type }}'] = {
        id: {{ $opt->id }},
        choices: @json($opt->choices),
        prices: @json($opt->prices),
        inputType: '{{ ($opt->input_type === 'dropdown') ? 'dropdown' : $opt->input_type }}',
    };
    @endforeach

    function cacheOriginalValues() {
        document.querySelectorAll('#pricingOptions select').forEach(select => {
            Array.from(select.options).forEach((option, idx) => {
                if (!select.dataset['originalText' + idx]) {
                    select.dataset['originalText' + idx] = option.textContent;
                    select.dataset['originalPrice' + idx] = option.dataset.optionPrice;
                }
            });
        });
    }

    function applyConditions() {
        // Reset all options to original state
        Object.keys(optionsByType).forEach(optionType => {
            const opt = optionsByType[optionType];
            if (opt.inputType === 'dropdown') {
                const select = document.querySelector(`select[data-option-id="${opt.id}"]`);
                if (!select) return;

                Array.from(select.options).forEach((option, idx) => {
                    option.disabled = false;
                    option.style.display = '';
                    const originalText = select.dataset['originalText' + idx];
                    const originalPrice = select.dataset['originalPrice' + idx];
                    if (originalText) option.textContent = originalText;
                    if (originalPrice) option.dataset.optionPrice = originalPrice;
                });
            }
        });

        // Apply conditions based on current selections
        conditionsData.forEach(cond => {
            const sourceSelect = document.querySelector(`select[data-option-id="${cond.source_option_id}"]`);
            if (!sourceSelect) return;

            const selectedIdx = parseInt(sourceSelect.value);
            if (selectedIdx === cond.when_choice_index) {
                applyCondition(cond);
            }
        });
    }

    function applyCondition(cond) {
        const affectedOption = optionsByType[cond.affects_option_type];
        if (!affectedOption) return;

        if (affectedOption.inputType === 'dropdown') {
            const select = document.querySelector(`select[data-option-id="${affectedOption.id}"]`);
            if (select) {
                cond.hide_choices.forEach(idx => {
                    if (select.options[idx]) {
                        select.options[idx].disabled = true;
                        select.options[idx].style.display = 'none';
                    }
                });

                if (Object.keys(cond.price_modifiers).length > 0) {
                    Array.from(select.options).forEach((option, idx) => {
                        const modKey = String(idx);
                        if (cond.price_modifiers[modKey] !== undefined || cond.price_modifiers[idx] !== undefined) {
                            const newPrice = parseFloat(cond.price_modifiers[modKey] ?? cond.price_modifiers[idx]);
                            const originalText = select.dataset['originalText' + idx].replace(/\(\+?\$[\d,.]+\)/g, '').trim();
                            const priceText = newPrice > 0 ? ` (+$${newPrice.toFixed(2)})` : '';
                            option.dataset.optionPrice = newPrice;
                            option.textContent = originalText + priceText;
                        }
                    });
                }
            }
        } else if (affectedOption.inputType === 'radio' || affectedOption.inputType === 'checkbox') {
            const container = document.querySelector(`[data-option-type="${cond.affects_option_type}"]`);
            if (container) {
                cond.hide_choices.forEach(idx => {
                    const label = container.querySelectorAll('label')[idx];
                    if (label) {
                        label.style.display = 'none';
                        const input = label.querySelector('input');
                        if (input) {
                            input.disabled = true;
                            if (input.checked) {
                                input.checked = false;
                                container.querySelector('input:not([disabled])')?.click();
                            }
                        }
                    }
                });

                if (Object.keys(cond.price_modifiers).length > 0) {
                    const labels = container.querySelectorAll('label');
                    labels.forEach((label, idx) => {
                        const modKey = String(idx);
                        if (cond.price_modifiers[modKey] !== undefined || cond.price_modifiers[idx] !== undefined) {
                            const newPrice = parseFloat(cond.price_modifiers[modKey] ?? cond.price_modifiers[idx]);
                            const input = label.querySelector('input');
                            if (input) input.dataset.optionPrice = newPrice;
                            const priceSpan = label.querySelector('.price-label');
                            if (priceSpan) {
                                if (newPrice > 0) {
                                    priceSpan.textContent = `+$${newPrice.toFixed(2)}`;
                                    priceSpan.style.display = '';
                                } else {
                                    priceSpan.style.display = 'none';
                                }
                            }
                        }
                    });
                }
            }
        }
    }

    function getEffectivePrice(optionId, choiceIndex) {
        let price = 0;
        const sourceOption = Object.values(optionsByType).find(o => o.id === optionId);
        if (sourceOption && sourceOption.prices[choiceIndex]) {
            price = parseFloat(sourceOption.prices[choiceIndex]);
        }

        conditionsData.forEach(cond => {
            const sourceEl = document.querySelector(`select[data-option-id="${cond.source_option_id}"]`);
            let isSelected = false;
            if (sourceEl) {
                isSelected = parseInt(sourceEl.value) === cond.when_choice_index;
            } else {
                const radio = document.querySelector(`input[name="option_${cond.source_option_id}"][value="${cond.when_choice_index}"]:checked`);
                isSelected = !!radio;
            }
            if (isSelected && cond.affects_option_type) {
                const affected = optionsByType[cond.affects_option_type];
                if (affected && affected.id === optionId) {
                    const modKey = String(choiceIndex);
                    if (cond.price_modifiers[modKey] !== undefined || cond.price_modifiers[choiceIndex] !== undefined) {
                        price = parseFloat(cond.price_modifiers[modKey] ?? cond.price_modifiers[choiceIndex]);
                    }
                }
            }
        });

        return price;
    }

    function calculatePrice() {
        let totalPrice = basePrice;

        document.querySelectorAll('#pricingOptions select').forEach(select => {
            const optionId = parseInt(select.dataset.optionId);
            const selectedIdx = parseInt(select.value);
            if (!isNaN(optionId) && !isNaN(selectedIdx)) {
                totalPrice += getEffectivePrice(optionId, selectedIdx);
            }
        });

        document.querySelectorAll('#pricingOptions input[type="radio"]:checked').forEach(radio => {
            const optionId = parseInt(radio.name.replace('option_', ''));
            const selectedIdx = parseInt(radio.value);
            if (!isNaN(optionId) && !isNaN(selectedIdx)) {
                totalPrice += getEffectivePrice(optionId, selectedIdx);
            }
        });

        document.querySelectorAll('#pricingOptions input[type="checkbox"]:checked').forEach(checkbox => {
            const optionId = parseInt(checkbox.name.replace('option_', '').replace('[]', ''));
            const selectedIdx = parseInt(checkbox.value);
            if (!isNaN(optionId) && !isNaN(selectedIdx)) {
                totalPrice += getEffectivePrice(optionId, selectedIdx);
            }
        });

        const quantity = parseInt(quantityInput.value) || 1;
        totalPrice = totalPrice * quantity;

        totalPriceEl.textContent = '$' + totalPrice.toFixed(2);
    }

    document.querySelectorAll('#pricingOptions select').forEach(select => {
        select.addEventListener('change', function() {
            applyConditions();
            calculatePrice();
        });
    });

    document.querySelectorAll('#pricingOptions input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            applyConditions();
            calculatePrice();
        });
    });

    document.querySelectorAll('#pricingOptions input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            applyConditions();
            calculatePrice();
        });
    });

    quantityInput.addEventListener('input', calculatePrice);

    cacheOriginalValues();
    applyConditions();
    calculatePrice();
});
</script>
@endif
<script>
// Artwork Upload
    window.clearArtwork = function() {
        const artworkFileInput = document.getElementById('artwork-file-input');
        const artworkFiles = document.getElementById('artwork-files');
        const artworkDropContent = document.getElementById('artwork-drop-content');
        const artworkPreview = document.getElementById('artwork-preview');
        const artworkUploaded = document.getElementById('artwork-uploaded');

        if (artworkFileInput) artworkFileInput.value = '';
        if (artworkFiles) artworkFiles.innerHTML = '';
        if (artworkDropContent) artworkDropContent.classList.remove('hidden');
        if (artworkPreview) artworkPreview.classList.add('hidden');
        if (artworkUploaded) artworkUploaded.value = '';
    };

document.addEventListener('DOMContentLoaded', function() {
    const artworkDropZone = document.getElementById('artwork-drop-zone');
    const artworkFileInput = document.getElementById('artwork-file-input');
    const artworkDropContent = document.getElementById('artwork-drop-content');
    const artworkPreview = document.getElementById('artwork-preview');
    const artworkFiles = document.getElementById('artwork-files');
    const artworkUploaded = document.getElementById('artwork-uploaded');

    if (artworkDropZone) {
        artworkDropZone.addEventListener('click', () => artworkFileInput.click());

        artworkDropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            artworkDropZone.classList.add('border-blue-500', 'bg-blue-50');
        });

        artworkDropZone.addEventListener('dragleave', () => {
            artworkDropZone.classList.remove('border-blue-500', 'bg-blue-50');
        });

        artworkDropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            artworkDropZone.classList.remove('border-blue-500', 'bg-blue-50');
            handleArtworkFiles(e.dataTransfer.files);
        });

        artworkFileInput.addEventListener('change', () => {
            handleArtworkFiles(artworkFileInput.files);
        });
    }

    window.handleArtworkFiles = function(files) {
        if (files.length === 0) return;

        artworkFiles.innerHTML = '';
        let fileNames = [];

        Array.from(files).forEach(file => {
            if (!file) return;

            fileNames.push(file.name);
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 bg-white p-3 rounded border';
            div.innerHTML = `
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-700 truncate">${file.name}</p>
                    <p class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                </div>
            `;
            artworkFiles.appendChild(div);
        });

        artworkDropContent.classList.add('hidden');
        artworkPreview.classList.remove('hidden');
        artworkUploaded.value = fileNames.join(',');
    };
});
</script>
@endpush
