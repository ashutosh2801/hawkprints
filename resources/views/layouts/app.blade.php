<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
    $companyName = \App\Models\Setting::get('company_name', 'Hawk Prints');
    $seoTitle = \App\Models\Setting::get('seo_title', $companyName . ' - Quality Printing Services');
    $seoDescription = \App\Models\Setting::get('seo_description', 'One stop for all your printing needs - Business cards, banners, sublimation, and more.');
    $seoKeywords = \App\Models\Setting::get('seo_keywords', 'printing, business cards, banners, sublimation, marketing materials');
    $favicon = \App\Models\Setting::get('favicon', '');
    @endphp
    <title>@yield('title', $seoTitle)</title>
    <meta name="description" content="@yield('meta_description', $seoDescription)">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if($favicon)
    <link rel="icon" type="image/png" href="{{ $favicon }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        @include('components.header')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('components.footer')
    </div>

    @stack('scripts')
</body>
</html>