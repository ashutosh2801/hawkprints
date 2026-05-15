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
    <div x-data="app()" class="min-h-screen">
        <!-- Fixed Top Bar -->
        <header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 shadow-sm z-50 flex items-center justify-between px-4">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <a href="/admin" class="text-lg font-bold text-gray-800">GTA<span class="text-blue-500">Coach</span> <span class="text-xs text-gray-400 font-normal">Admin</span></a>
            </div>
            <div class="flex items-center gap-1">
                <!-- Newsletter -->
                <a href="/admin/newsletter" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg" title="Newsletter">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </a>
                <!-- Software Development -->
                <a href="/admin/software-development" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg" title="Software Development Requests">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </a>
                <!-- Contact Inquiries -->
                <a href="/admin/contact-inquiries" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg" title="Contact Inquiries">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </a>
                <!-- Notifications -->
                <div x-data="notifDropdown()" class="relative" @keydown.escape="open = false">
                    <button @click="toggle()" class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1"></span>
                    </button>
                    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50" x-transition>
                        <div class="p-3 border-b border-gray-100 flex justify-between items-center">
                            <span class="font-semibold text-sm" x-text="'Notifications (' + unreadCount + ')'"></span>
                            <button @click="markAllRead()" class="text-xs text-blue-600 hover:underline">Mark all read</button>
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            <template x-for="n in items" :key="n.id">
                                <div class="p-3 border-b border-gray-50 hover:bg-gray-50 cursor-pointer" :class="n.is_read ? '' : 'bg-blue-50'" @click="n.type === 'order' ? window.location='/admin/orders/' + (n.data.order_id || n.data.id) : ''">
                                    <div class="flex items-start gap-2">
                                        <span class="text-xs font-semibold px-1.5 py-0.5 rounded shrink-0 mt-0.5" :class="typeClass(n.type)">
                                            <span x-text="typeLabel(n.type)"></span>
                                        </span>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-xs font-medium" x-text="titleText(n)"></p>
                                            <p class="text-xs text-gray-400 truncate" x-text="subText(n)"></p>
                                            <p class="text-xs text-gray-300 mt-0.5" x-text="timeAgo(n.created_at)"></p>
                                        </div>
                                        <button @click.stop="markRead(n.id)" x-show="!n.is_read" class="shrink-0 text-gray-300 hover:text-green-500">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <div x-show="items.length === 0" class="p-6 text-center text-gray-400 text-sm">No notifications</div>
                        </div>
                        <a href="{{ route('admin.notifications') }}" class="block p-2.5 text-center text-sm text-blue-600 hover:bg-gray-50 rounded-b-lg border-t border-gray-100">
                            View all notifications
                        </a>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div x-data="{ open: false }" class="relative" @keydown.escape="open = false">
                    <button @click="open = !open" class="flex items-center gap-2 p-1.5 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="text-sm font-medium hidden sm:block">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50" x-transition>
                        <div class="p-3 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? '' }}</p>
                        </div>
                        <a href="{{ route('admin.settings') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.825-1.504 2.347-1.504 3.172 0l1.45 2.551c.825 1.454.217 3.288-1.285 3.943a3.491 3.491 0 01-2.924.784l-2.56-.818c-.955-.305-1.967.305-2.346 1.345l-.818 2.56c-.305.954.296 1.967 1.345 2.346l2.56.818c1.407.447 2.924-.217 3.288-1.54l2.257-3.943c.448-1.407-.217-2.924-1.54-3.288l-2.56-.818c-.954-.305-1.451-1.285-1.15-2.239z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Settings
                        </a>
                        <div class="border-t border-gray-100">
                            <form action="/admin/logout" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex pt-16">
            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'w-64' : 'w-0'" class="bg-gray-900 text-white fixed left-0 top-16 h-full transition-all duration-300 overflow-hidden z-40">
                <nav class="p-4 space-y-1 w-64">
                    <a href="/admin" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin') && !request()->is('admin/dashboard')) bg-gray-700 @endif">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    <div x-data="{ open: {{ request()->is('admin/products*') || request()->is('admin/categories*') || request()->is('admin/pricing-option-types*') || request()->is('admin/coupons*') || request()->is('admin/shipping-methods*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/products*') || request()->is('admin/categories*') || request()->is('admin/pricing-option-types*') || request()->is('admin/coupons*') || request()->is('admin/shipping-methods*')) bg-gray-700 @endif">
                            <div class="flex items-center gap-2 min-w-0">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                <span class="truncate">Inventory</span>
                            </div>
                            <svg class="w-4 h-4 shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-collapse class="ml-4 space-y-1 border-l border-gray-700 pl-4">
                            <a href="/admin/products" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/products*')) bg-gray-700 @endif text-sm text-gray-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Products
                            </a>
                            <a href="/admin/categories" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/categories*')) bg-gray-700 @endif text-sm text-gray-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                Categories
                            </a>
                            <a href="/admin/pricing-option-types" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/pricing-option-types*')) bg-gray-700 @endif text-sm text-gray-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                                Pricing Types
                            </a>
                            <a href="/admin/coupons" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/coupons*')) bg-gray-700 @endif text-sm text-gray-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.509 0 .926.314 1.006.737l2.963 8a.994.994 0 01-.042.7c-.073.26-.21.495-.404.7L9 17l-3 3m0 0l.4-.4a1.021 1.021 0 00.1-.13 1.543 1.543 0 00-.06-1.65L6 17m0 0V9m0 8v8m8-8V9"/></svg>
                                Coupons
                            </a>
                            <a href="/admin/shipping-methods" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/shipping-methods*')) bg-gray-700 @endif text-sm text-gray-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a1 1 0 001 1h10a1 1 0 001-1V8m-9 4h4"/></svg>
                                Shipping
                            </a>
                        </div>
                    </div>

                    <a href="/admin/orders" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/orders*')) bg-gray-700 @endif">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Orders
                    </a>

                    <a href="/admin/testimonials" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/testimonials*')) bg-gray-700 @endif">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        Testimonials
                    </a>

                    <div x-data="{ open: {{ request()->is('admin/software-development*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/software-development*')) bg-gray-700 @endif">
                            <div class="flex items-center gap-2 min-w-0">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                <span class="truncate">Software Dev</span>
                            </div>
                            <svg class="w-4 h-4 shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-collapse class="ml-4 space-y-1 border-l border-gray-700 pl-4">
                            <a href="/admin/software-development" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->routeIs('admin.software-development') && !request()->is('admin/software-development/content*')) bg-gray-700 @endif text-sm text-gray-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Requests
                            </a>
                            <a href="/admin/software-development/content" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/software-development/content*')) bg-gray-700 @endif text-sm text-gray-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Page Content
                            </a>
                        </div>
                    </div>

                    <a href="/admin/sliders" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/sliders*')) bg-gray-700 @endif">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Sliders
                    </a>

                    <a href="/admin/media-library" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/media-library*')) bg-gray-700 @endif">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Media Library
                    </a>

                    <div x-data="{ open: {{ request()->is('admin/home-page*') || request()->is('admin/settings*') || request()->is('admin/menu-items*') ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-2 px-4 py-2 rounded hover:bg-gray-700 @if(request()->is('admin/home-page*') || request()->is('admin/settings*') || request()->is('admin/menu-items*')) bg-gray-700 @endif">
                            <div class="flex items-center gap-2 min-w-0">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.825-1.504 2.347-1.504 3.172 0l1.45 2.551c.825 1.454.217 3.288-1.285 3.943a3.491 3.491 0 01-2.924.784l-2.56-.818c-.955-.305-1.967.305-2.346 1.345l-.818 2.56c-.305.954.296 1.967 1.345 2.346l2.56.818c1.407.447 2.924-.217 3.288-1.54l2.257-3.943c.448-1.407-.217-2.924-1.54-3.288l-2.56-.818c-.954-.305-1.451-1.285-1.15-2.239z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="truncate">Settings</span>
                            </div>
                            <svg class="w-4 h-4 shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-collapse class="ml-4 space-y-1 border-l border-gray-700 pl-4">
                            <a href="/admin/home-page" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/home-page*')) bg-gray-700 @endif text-sm text-gray-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                Home Page
                            </a>
                            <a href="/admin/settings" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/settings*')) bg-gray-700 @endif text-sm text-gray-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.825-1.504 2.347-1.504 3.172 0l1.45 2.551c.825 1.454.217 3.288-1.285 3.943a3.491 3.491 0 01-2.924.784l-2.56-.818c-.955-.305-1.967.305-2.346 1.345l-.818 2.56c-.305.954.296 1.967 1.345 2.346l2.56.818c1.407.447 2.924-.217 3.288-1.54l2.257-3.943c.448-1.407-.217-2.924-1.54-3.288l-2.56-.818c-.954-.305-1.451-1.285-1.15-2.239z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Settings
                            </a>
                            <a href="/admin/menu-items" class="flex items-center gap-2 px-4 py-1.5 rounded hover:bg-gray-700 @if(request()->is('admin/menu-items*')) bg-gray-700 @endif text-sm text-gray-300">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                Menu Items
                            </a>
                        </div>
                    </div>

                    <div class="pt-4 mt-4 border-t border-gray-700">
                        <a href="/" target="_blank" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-700 text-gray-300">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4a2 2 0 00-2-2h-4M10 6V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                            View Site
                        </a>
                    </div>
                </nav>
            </aside>

            <!-- Main Content -->
            <main :class="sidebarOpen ? 'ml-64' : 'ml-0'" class="flex-1 p-8 transition-all duration-300 min-h-screen">
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.8/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js" defer></script>
    <script>
    function app() {
        return {
            sidebarOpen: true,
        }
    }
    function notifDropdown() {
        return {
            open: false,
            unreadCount: 0,
            items: [],
            init() {
                this.fetchNotifs();
                setInterval(() => this.fetchNotifs(), 30000);
            },
            fetchNotifs() {
                var self = this;
                fetch('/admin/notifications/unread')
                    .then(r => r.json())
                    .then(d => { self.unreadCount = d.count; self.items = d.notifications; });
            },
            toggle() { this.open = !this.open; if (this.open) this.fetchNotifs(); },
            typeClass(type) {
                var m = { order:'bg-blue-100 text-blue-700', signup:'bg-green-100 text-green-700', newsletter:'bg-purple-100 text-purple-700', contact:'bg-orange-100 text-orange-600', software:'bg-indigo-100 text-indigo-700' };
                return m[type] || 'bg-gray-100 text-gray-600';
            },
            typeLabel(type) {
                var m = { order:'Order', signup:'Signup', newsletter:'Newsletter', contact:'Contact', software:'Software' };
                return m[type] || type;
            },
            titleText(n) {
                if (n.type === 'order') return 'New order #' + (n.data.order_number || '');
                if (n.type === 'signup') return 'New customer: ' + (n.data.name || '');
                if (n.type === 'newsletter') return 'New subscriber: ' + (n.data.email || '');
                if (n.type === 'contact') return 'Message from ' + (n.data.name || '');
                if (n.type === 'software') return 'Software dev inquiry from ' + (n.data.name || '');
                return 'Notification';
            },
            subText(n) {
                if (n.type === 'order') return (n.data.customer_name || '') + ' - $' + (n.data.total || '0').toLocaleString();
                if (n.type === 'signup') return n.data.email || '';
                if (n.type === 'newsletter') return n.data.email || '';
                if (n.type === 'contact') return (n.data.email || '') + ' - ' + (n.data.phone || '');
                if (n.type === 'software') return (n.data.service || '').replace(/_/g, ' ') + ' - ' + (n.data.email || '');
                return '';
            },
            timeAgo(ts) {
                var diff = Date.now() - new Date(ts).getTime();
                var min = Math.floor(diff / 60000);
                if (min < 1) return 'just now';
                if (min < 60) return min + 'm ago';
                var hrs = Math.floor(min / 60);
                if (hrs < 24) return hrs + 'h ago';
                return Math.floor(hrs / 24) + 'd ago';
            },
            markRead(id) {
                var self = this;
                fetch('/admin/notifications/' + id + '/read', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                    .then(r => r.json()).then(d => { if (d.success) self.fetchNotifs(); });
            },
            markAllRead() {
                var self = this;
                fetch('/admin/notifications/read-all', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                    .then(r => r.json()).then(d => { if (d.success) self.fetchNotifs(); });
            }
        }
    }
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
