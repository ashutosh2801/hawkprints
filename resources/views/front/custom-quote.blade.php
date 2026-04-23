@extends('layouts.app')

@section('title', 'Custom Quote - Hawk Prints')

@section('content')
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-8">Custom Quote Request</h1>
        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
            Can't find what you're looking for? Tell us about your project and we'll provide you with a custom quote.
        </p>

        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <form action="#" method="POST">
                @csrf
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                            <input type="text" name="company" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="tel" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Type *</label>
                        <select name="product_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                            <option value="">Select a product type</option>
                            <option value="business-cards">Business Cards</option>
                            <option value="marketing">Marketing Materials</option>
                            <option value="large-format">Large Format</option>
                            <option value="apparel">Apparel</option>
                            <option value="sublimation">Sublimation</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input type="number" name="quantity" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Size/Dimensions</label>
                        <input type="text" name="size" placeholder="e.g., 4x6 inches, A4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Paper/Material</label>
                        <input type="text" name="material" placeholder="e.g., 14pt cardstock, glossy" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Describe Your Project *</label>
                        <textarea name="description" rows="4" required placeholder="Please describe your project in detail..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Attach Files (optional)</label>
                        <input type="file" name="files[]" multiple accept=".pdf,.ai,.psd,.jpg,.png" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, AI, PSD, JPG, PNG</p>
                    </div>

                    <button type="submit" class="w-full py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold">
                        Request Quote
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection