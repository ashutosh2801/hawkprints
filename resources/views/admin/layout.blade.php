<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Hawk Prints</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-gray-900 text-white fixed h-full">
            <div class="p-4 border-b border-gray-700">
                <a href="/admin" class="text-xl font-bold">HAWK<span class="text-blue-500">PRINTS</span></a>
                <p class="text-xs text-gray-400 mt-1">Admin Panel</p>
            </div>
            
            <nav class="p-4 space-y-1">
                <a href="/admin" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin')) bg-gray-700 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                
                <a href="/admin/products" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/products*')) bg-gray-700 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Products
                </a>
                
                <a href="/admin/categories" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/categories*')) bg-gray-700 @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Categories
                </a>
                
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
</body>
</html>