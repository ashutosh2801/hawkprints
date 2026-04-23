<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hawk Prints')</title>
    <meta name="description" content="@yield('meta_description', 'One stop for all your printing needs')">
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