@php
    $companyName = \App\Models\Setting::get('company_name', 'Five Rivers Print');
    $logo = \App\Models\Setting::get('logo');
    $allHeaderItems = \App\Models\MenuItem::where('location', 'header')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();
    $headerMenuTree = $allHeaderItems->whereNull('parent_id');
    $shopProducts = \App\Models\Product::where('is_active', true)
        ->orderBy('name')
        ->get(['id', 'name', 'slug']);
@endphp

<header class="bg-white border-b border-gray-100" x-data="{ mobileOpen: false }" style="position: relative; z-index: 9999;">
    <!-- Top Bar -->
    <div class="bg-gray-900 text-gray-300 text-xs">
        <div class="container mx-auto px-4 py-2 flex justify-between items-center">
            <div class="flex items-center gap-5">
                <a href="mailto:info@fiveriversprint.ca" class="flex items-center gap-1.5 hover:text-white transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    info@fiveriversprint.ca
                </a>
                <a href="tel:905-744-0013" class="flex items-center gap-1.5 hover:text-white transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    905-744-0013
                </a>
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
                <div class="text-xl font-bold text-gray-900 tracking-tight">Five Rivers Print</div>
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

            <!-- Cart & Account -->
            <div class="flex items-center gap-3">
                <a href="/cart" class="relative p-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-full transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @if($cartCount > 0)
                    <span class="absolute -top-0.5 -right-0.5 bg-blue-700 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-medium">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                <div class="relative group">
                    <button class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded-full transition-all">
                        <div class="w-7 h-7 bg-blue-700 rounded-full flex items-center justify-center text-xs font-bold text-white">
                            {{ \Illuminate\Support\Facades\Auth::user()->name[0] }}
                        </div>
                        <span class="hidden lg:inline font-medium">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
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
                <a href="{{ route('customer.login') }}" class="hidden lg:flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded-full transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Sign In
                </a>
                @endauth

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
    <nav id="mainNav" class="border-t border-gray-100 bg-white hidden lg:block">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Shop All Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors flex items-center gap-1.5">
                            All Products
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="nav-dropdown absolute left-0 top-full pt-2 transition-all duration-200" style="z-index: 9999;">
                            <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-6 w-[1000px] max-h-[62vh] overflow-y-auto" style="scrollbar-width: thin;">
                                <div class="pt-0">
                                    @php
                                        $grouped = [];
                                        foreach($shopProducts as $p) {
                                            $letter = strtoupper(substr($p->name, 0, 1));
                                            if (!isset($grouped[$letter])) $grouped[$letter] = [];
                                            $grouped[$letter][] = $p;
                                        }
                                        ksort($grouped);
                                    @endphp
                                    @foreach($grouped as $letter => $prods)
                                    <div class="mb-5 last:mb-0">
                                        <div class="flex items-center gap-3 mb-2">
                                            <div class="w-7 h-7 bg-blue-700 text-white rounded-full flex items-center justify-center text-sm font-bold">{{ $letter }}</div>
                                            <div class="flex-1 border-t border-gray-200"></div>
                                        </div>
                                        <div class="grid grid-cols-4 gap-2">
                                            @foreach($prods as $p)
                                            <a href="/shop/product/{{ $p->slug }}" class="px-3 py-2 text-sm text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors truncate">
                                                {{ $p->name }}
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($headerMenuTree->count() > 0)
                    <div class="w-px h-6 bg-gray-200 mx-2"></div>
                    @foreach($headerMenuTree as $item)
                        @include('components.partials.menu-node', ['item' => $item, 'allItems' => $allHeaderItems, 'level' => 0])
                    @endforeach
                    @endif
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

            <div x-data="{ shopOpen: false }">
                <button @click="shopOpen = !shopOpen" class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">
                    Shop All
                    <svg class="w-3.5 h-3.5 transition-transform" :class="shopOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="shopOpen" x-cloak class="ml-4 space-y-1 border-l border-gray-200 pl-4">
                    @php
                        $mobileGrouped = [];
                        foreach($shopProducts as $p) {
                            $letter = strtoupper(substr($p->name, 0, 1));
                            if (!isset($mobileGrouped[$letter])) $mobileGrouped[$letter] = [];
                            $mobileGrouped[$letter][] = $p;
                        }
                        ksort($mobileGrouped);
                    @endphp
                    @foreach($mobileGrouped as $letter => $prods)
                    <div class="pt-2">
                        <div class="flex items-center gap-2 px-4 mb-1">
                            <div class="w-6 h-6 bg-blue-700 text-white rounded-full flex items-center justify-center text-xs font-bold">{{ $letter }}</div>
                            <div class="flex-1 border-t border-gray-200"></div>
                        </div>
                        @foreach($prods as $p)
                        <a href="/shop/product/{{ $p->slug }}" class="block px-4 py-1.5 text-sm text-gray-600 hover:text-blue-700">
                            {{ $p->name }}
                        </a>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>

            @if($headerMenuTree->count() > 0)
                @foreach($headerMenuTree as $item)
                    @include('components.partials.mobile-menu-node', ['item' => $item, 'allItems' => $allHeaderItems])
                @endforeach
            @endif

            @guest
                <hr class="my-2 border-gray-100">
                <a href="{{ route('customer.login') }}" class="block px-4 py-2.5 text-sm font-medium text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">Sign In</a>
            @endguest
        </div>
    </div>
</header>

<style>
.nav-dropdown { opacity: 0; visibility: hidden; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.group').forEach(function(group) {
        var dropdown = group.querySelector('.nav-dropdown');
        if (!dropdown) return;
        group.addEventListener('mouseenter', function() {
            dropdown.style.opacity = '1';
            dropdown.style.visibility = 'visible';
        });
        group.addEventListener('mouseleave', function() {
            dropdown.style.opacity = '0';
            dropdown.style.visibility = 'hidden';
        });
    });
});

(function() {
    const nav = document.getElementById('mainNav');
    if (!nav) return;

    let placeholder = null;
    let navOffset = 0;

    function init() {
        navOffset = nav.offsetTop;
        placeholder = document.createElement('div');
        placeholder.style.display = 'none';
        placeholder.style.height = nav.offsetHeight + 'px';
        nav.parentNode.insertBefore(placeholder, nav);
    }

    function onScroll() {
        if (window.scrollY >= navOffset) {
            nav.classList.add('fixed');
            nav.style.top = '0';
            nav.style.left = '0';
            nav.style.right = '0';
            nav.style.zIndex = '50';
            placeholder.style.display = 'block';
        } else {
            nav.classList.remove('fixed');
            nav.style.top = '';
            nav.style.left = '';
            nav.style.right = '';
            nav.style.zIndex = '';
            placeholder.style.display = 'none';
        }
    }

    init();
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', function() {
        init();
        onScroll();
    });
})();
</script>
