@php
    $companyName = \App\Models\Setting::get('company_name', 'Hawk Prints');
    $logo = \App\Models\Setting::get('logo');
@endphp

<header class="bg-white border-b border-gray-100 sticky top-0 z-50" x-data="{ mobileOpen: false }">
    <!-- Top Bar -->
    <div class="bg-gray-900 text-gray-300 text-xs">
        <div class="container mx-auto px-4 py-2 flex justify-between items-center">
            <div class="flex items-center gap-5">
                <a href="mailto:info@hawkprints.ca" class="flex items-center gap-1.5 hover:text-white transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    info@hawkprints.ca
                </a>
                <a href="tel:905-744-0013" class="flex items-center gap-1.5 hover:text-white transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    905-744-0013
                </a>
            </div>
            <div class="hidden md:flex items-center gap-5">
                @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2 hover:text-white transition-colors">
                            <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-xs font-bold text-white">
                                {{ \Illuminate\Support\Facades\Auth::user()->name[0] }}
                            </div>
                            <span>{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                            <svg class="w-3 h-3 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-gray-100">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-gray-700 hover:bg-gray-50 hover:text-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('orders') }}" class="flex items-center gap-2 px-4 py-2.5 text-gray-700 hover:bg-gray-50 hover:text-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                My Orders
                            </a>
                            <a href="{{ route('profile') }}" class="flex items-center gap-2 px-4 py-2.5 text-gray-700 hover:bg-gray-50 hover:text-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Profile
                            </a>
                            <hr class="my-1.5 border-gray-100">
                            <form action="{{ route('customer.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('customer.login') }}" class="hover:text-white transition-colors">Sign In</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between gap-6">
            <!-- Logo -->
            <a href="/" class="flex-shrink-0">
                @if($logo)
                <img src="{{ $logo }}" alt="{{ $companyName }}" class="h-10 w-auto object-contain">
                @else
                <div class="text-xl font-bold text-gray-900 tracking-tight">Hawk<span class="text-blue-700">Prints</span></div>
                @endif
            </a>

            <!-- Search -->
            <form action="/shop" method="GET" class="hidden lg:flex flex-1 max-w-xl">
                <div class="relative w-full group">
                    <input type="text" name="search" placeholder="Search products..." class="w-full pl-5 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent focus:bg-white transition-all duration-300">
                    <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-9 h-9 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Cart & Mobile Menu -->
            <div class="flex items-center gap-3">
                <a href="/cart" class="relative p-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-full transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @if($cartCount > 0)
                    <span class="absolute -top-0.5 -right-0.5 bg-blue-700 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-medium">{{ $cartCount }}</span>
                    @endif
                </a>

                <!-- Mobile menu button -->
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-full transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileOpen" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="border-t border-gray-100 hidden lg:block">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Shop All Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors flex items-center gap-1.5">
                            Shop All
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute left-0 top-full pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-2 min-w-52">
                                <a href="/shop" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    All Products
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="w-px h-6 bg-gray-200"></div>

                    <a href="/shop/category/business-cards" class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors">Business Cards</a>
                    <a href="/shop/category/marketing" class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors">Marketing</a>
                    <a href="/shop/category/large-format" class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors">Large Format</a>
                    <a href="/shop/category/apparels" class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors">Apparels</a>
                    <a href="/shop/category/sublimation" class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors">Sublimation</a>

                    @if($menuItems->count() > 0)
                    <div class="w-px h-6 bg-gray-200"></div>
                    <div class="relative group">
                        <button class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors flex items-center gap-1.5">
                            More
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute left-0 top-full pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-2 min-w-56">
                                @foreach($menuItems as $item)
                                    @if($item->children->count() > 0)
                                    <div class="relative group/sub">
                                        <a href="{{ $item->effective_slug }}" class="flex items-center justify-between px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                            {{ $item->effective_name }}
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                        <div class="absolute left-full top-0 pt-2 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-200 min-w-52">
                                            <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-2">
                                                @foreach($item->children as $child)
                                                <a href="{{ $child->effective_slug }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                                    {{ $child->effective_name }}
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <a href="{{ $item->effective_slug }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                        {{ $item->effective_name }}
                                    </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="w-px h-6 bg-gray-200"></div>

                    <a href="/custom-quote" class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors">Custom Order</a>
                    <a href="/about" class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors">About Us</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div x-show="mobileOpen" x-cloak @click.away="mobileOpen = false" class="lg:hidden border-t border-gray-100 bg-white">
        <div class="container mx-auto px-4 py-4 space-y-1">
            <!-- Mobile Search -->
            <form action="/shop" method="GET" class="mb-4">
                <div class="relative">
                    <input type="text" name="search" placeholder="Search products..." class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-700">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>

            <a href="/shop" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">Shop All</a>
            <a href="/shop/category/business-cards" class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">Business Cards</a>
            <a href="/shop/category/marketing" class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">Marketing</a>
            <a href="/shop/category/large-format" class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">Large Format</a>
            <a href="/shop/category/apparels" class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">Apparels</a>
            <a href="/shop/category/sublimation" class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">Sublimation</a>

            @if($menuItems->count() > 0)
                @foreach($menuItems as $item)
                    <a href="{{ $item->effective_slug }}" class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">{{ $item->effective_name }}</a>
                    @foreach($item->children as $child)
                        <a href="{{ $child->effective_slug }}" class="block px-8 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">{{ $child->effective_name }}</a>
                    @endforeach
                @endforeach
            @endif

            <hr class="my-2 border-gray-100">
            <a href="/custom-quote" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">Custom Order</a>
            <a href="/about" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">About Us</a>

            @guest
                <hr class="my-2 border-gray-100">
                <a href="{{ route('customer.login') }}" class="block px-4 py-2.5 text-sm font-medium text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">Sign In</a>
            @endguest
        </div>
    </div>
</header>
