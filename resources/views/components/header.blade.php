<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="bg-blue-700 text-white text-sm py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="mailto:info@hawkprints.ca" class="flex items-center gap-2 hover:text-blue-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    info@hawkprints.ca
                </a>
                <a href="tel:905-744-0013" class="flex items-center gap-2 hover:text-blue-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Help is here 905-744-0013
                </a>
            </div>
            <div class="flex items-center gap-4">
                <a href="/contact" class="hover:text-blue-200">Sign in</a>
                <a href="/cart" class="flex items-center gap-2 hover:text-blue-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Cart
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <a href="/" class="flex items-center">
                <div class="text-2xl font-bold text-blue-700">HAWK<span class="text-gray-800">PRINTS</span></div>
            </a>

            <form action="/shop" method="GET" class="hidden md:flex flex-1 max-w-xl mx-8">
                <div class="relative w-full">
                    <input type="text" name="search" placeholder="Search products..." class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent">
                    <button type="submit" class="absolute right-0 top-0 h-full px-4 bg-blue-700 text-white rounded-r-lg hover:bg-blue-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="flex items-center gap-4">
                <a href="/cart" class="relative p-2 text-gray-600 hover:text-blue-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <nav class="bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div class="hidden md:flex items-center">
                    <div class="relative group">
                        <button class="px-4 py-3 hover:bg-blue-700 transition flex items-center gap-1">
                            <a href="/shop">All Products</a>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>

                    <a href="/shop/category/business-cards" class="px-4 py-3 hover:bg-blue-700 transition">Business Cards</a>
                    <a href="/shop/category/marketing" class="px-4 py-3 hover:bg-blue-700 transition">Marketing</a>
                    <a href="/shop/category/large-format" class="px-4 py-3 hover:bg-blue-700 transition">Large Format</a>
                    <a href="/shop/category/apparels" class="px-4 py-3 hover:bg-blue-700 transition">Apparels</a>
                    <a href="/shop/category/sublimation" class="px-4 py-3 hover:bg-blue-700 transition">Sublimation</a>
                    <a href="/custom-quote" class="px-4 py-3 hover:bg-blue-700 transition">Custom Order</a>
                </div>

                <button class="md:hidden p-2 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>
</header>