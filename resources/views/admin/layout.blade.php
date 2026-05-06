<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - GTA Coach</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>.ql-editor{min-height:150px}.ql-container{font-size:14px}</style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-gray-900 text-white fixed h-full">
            <div class="p-4 border-b border-gray-700">
                <a href="/admin" class="text-xl font-bold">GTA<span class="text-blue-500">Coach</span></a>
                <p class="text-xs text-gray-400 mt-1">Admin Panel</p>
            </div>
            
            <nav class="p-4 space-y-1">
                <a href="/admin" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin') && !request()->is('admin/dashboard')) bg-gray-700 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <div x-data="{ open: {{ request()->is('admin/products*') || request()->is('admin/categories*') || request()->is('admin/pricing-option-types*') || request()->is('admin/coupons*') || request()->is('admin/shipping-methods*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/products*') || request()->is('admin/categories*') || request()->is('admin/pricing-option-types*') || request()->is('admin/coupons*') || request()->is('admin/shipping-methods*')) bg-gray-700 @endif">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            Inventory
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    
                    <div x-show="open" x-collapse class="ml-4 space-y-1 border-l border-gray-700 pl-4">
                        <a href="/admin/products" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/products*')) bg-gray-700 @endif text-sm text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            Products
                        </a>
                        <a href="/admin/categories" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/categories*')) bg-gray-700 @endif text-sm text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Categories
                        </a>
                        <a href="/admin/pricing-option-types" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/pricing-option-types*')) bg-gray-700 @endif text-sm text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                            Pricing Types
                        </a>
                        <a href="/admin/coupons" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/coupons*')) bg-gray-700 @endif text-sm text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.509 0 .926.314 1.006.737l2.963 8a.994.994 0 01-.042.7c-.073.26-.21.495-.404.7L9 17l-3 3m0 0l.4-.4a1.021 1.021 0 00.1-.13 1.543 1.543 0 00-.06-1.65L6 17m0 0V9m0 8v8m8-8V9"/></svg>
                            Coupons
                        </a>
                        <a href="/admin/shipping-methods" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/shipping-methods*')) bg-gray-700 @endif text-sm text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a1 1 0 001 1h10a1 1 0 001-1V8m-9 4h4"/></svg>
                            Shipping
                        </a>
                    </div>
                </div>
                
                <a href="/admin/orders" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/orders*')) bg-gray-700 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Orders
                </a>
                
                <a href="/admin/testimonials" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/testimonials*')) bg-gray-700 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    Testimonials
                </a>
                
                <a href="/admin/sliders" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/sliders*')) bg-gray-700 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Sliders
                </a>

                <a href="/admin/media-library" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/media-library*')) bg-gray-700 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Media Library
                </a>

                <div x-data="{ open: {{ request()->is('admin/home-page*') || request()->is('admin/settings*') || request()->is('admin/menu-items*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/home-page*') || request()->is('admin/settings*') || request()->is('admin/menu-items*')) bg-gray-700 @endif">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.825-1.504 2.347-1.504 3.172 0l1.45 2.551c.825 1.454.217 3.288-1.285 3.943a3.491 3.491 0 01-2.924.784l-2.56-.818c-.955-.305-1.967.305-2.346 1.345l-.818 2.56c-.305.954.296 1.967 1.345 2.346l2.56.818c1.407.447 2.924-.217 3.288-1.54l2.257-3.943c.448-1.407-.217-2.924-1.54-3.288l-2.56-.818c-.954-.305-1.451-1.285-1.15-2.239z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Settings
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    
                    <div x-show="open" x-collapse class="ml-4 space-y-1 border-l border-gray-700 pl-4">
                        <a href="/admin/home-page" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/home-page*')) bg-gray-700 @endif text-sm text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Home Page
                        </a>
                        <a href="/admin/settings" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/settings*')) bg-gray-700 @endif text-sm text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.825-1.504 2.347-1.504 3.172 0l1.45 2.551c.825 1.454.217 3.288-1.285 3.943a3.491 3.491 0 01-2.924.784l-2.56-.818c-.955-.305-1.967.305-2.346 1.345l-.818 2.56c-.305.954.296 1.967 1.345 2.346l2.56.818c1.407.447 2.924-.217 3.288-1.54l2.257-3.943c.448-1.407-.217-2.924-1.54-3.288l-2.56-.818c-.954-.305-1.451-1.285-1.15-2.239z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Settings
                        </a>
                        <a href="/admin/menu-items" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/menu-items*')) bg-gray-700 @endif text-sm text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            Menu Items
                        </a>
                    </div>
                </div>
                
                <a href="/admin/newsletter" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/newsletter*')) bg-gray-700 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Newsletter
                </a>
                
                <div class="pt-4 mt-4 border-t border-gray-700">
                    <a href="/" target="_blank" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4a2 2 0 00-2-2h-4M10 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                        View Site
                    </a>
                    <form action="/admin/logout" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>
        
        <main class="flex-1 ml-64 p-8">
            <header class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                @yield('breadcrumbs')
            </header>
            
            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
            @endif
            
            @if(session('error'))
            <div class="mb-4 p-4 bg-blue-100 text-blue-700 rounded-lg">{{ session('error') }}</div>
            @endif
            
            @yield('content')
        </main>
    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.plugin(window.AlpineCollapse);
        });
    </script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.wysiwyg').forEach(function(el) {
                var container = document.createElement('div');
                container.style.height = '200px';
                container.style.marginBottom = '50px';
                el.parentNode.insertBefore(container, el);
                el.style.display = 'none';
                
                var quill = new Quill(container, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });
                
                if (el.value) {
                    quill.root.innerHTML = el.value;
                }
                
                quill.on('editor-change', function() {
                    el.value = quill.root.innerHTML;
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
