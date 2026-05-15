<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
    $companyName = \App\Models\Setting::get('company_name', 'Five Rivers Print');
    $seoTitle = \App\Models\Setting::get('seo_title', $companyName . ' - Quality Printing Services');
    $seoDescription = \App\Models\Setting::get('seo_description', 'One stop for all your printing needs - Business cards, banners, sublimation, and more.');
    $seoKeywords = \App\Models\Setting::get('seo_keywords', 'printing, business cards, banners, sublimation, marketing materials');
    $favicon = \App\Models\Setting::get('favicon', '');
    $logo = \App\Models\Setting::get('logo', '');
    $trackingCode = \App\Models\Setting::get('tracking_code', '');
    $companyPhone = \App\Models\Setting::get('company_phone', '');
    $companyEmail = \App\Models\Setting::get('company_email', '');
    @endphp
    <title>@yield('title', $seoTitle)</title>
    <meta name="description" content="@yield('meta_description', $seoDescription)">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if($favicon)
    <link rel="icon" type="image/png" href="{{ $favicon }}">
    @endif

    @php
        $ogDefaultImage = \App\Models\Setting::get('og_image', '');
        $ogImage = $ogDefaultImage ?: ($logo ?: url('/images/og-default.jpg'));
        $facebookAppId = \App\Models\Setting::get('facebook_app_id', '');
        $twitterHandle = \App\Models\Setting::get('twitter_handle', '');
    @endphp
    <!-- Open Graph -->
    <meta property="og:site_name" content="{{ $companyName }}">
    <meta property="og:title" content="@yield('og_title', $seoTitle)">
    <meta property="og:description" content="@yield('og_description', $seoDescription)">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', $ogImage)">
    <meta property="og:image:alt" content="@yield('og_image_alt', $companyName)">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:locale" content="en_CA">
    @if($facebookAppId)
    <meta property="fb:app_id" content="{{ $facebookAppId }}">
    @endif

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', $seoTitle)">
    <meta name="twitter:description" content="@yield('og_description', $seoDescription)">
    <meta name="twitter:image" content="@yield('og_image', $ogImage)">
    <meta name="twitter:image:alt" content="@yield('og_image_alt', $companyName)">
    @if($twitterHandle)
    <meta name="twitter:site" content="{{ $twitterHandle }}">
    <meta name="twitter:creator" content="{{ $twitterHandle }}">
    @endif

    <!-- JSON-LD Organization -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ $companyName }}",
        "url": "{{ url('/') }}",
        "logo": "{{ $logo }}",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "{{ $companyPhone }}",
            "email": "{{ $companyEmail }}",
            "contactType": "customer service"
        }
    }
    </script>

    <!-- JSON-LD WebSite -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "WebSite",
        "name": "{{ $companyName }}",
        "url": "{{ url('/') }}",
        "potentialAction": {
            "@type": "SearchAction",
            "target": {
                "@type": "EntryPoint",
                "urlTemplate": "{{ url('/shop') }}?search={search_term_string}"
            },
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    @if($trackingCode)
    {!! $trackingCode !!}
    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/css/intlTelInput.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    blue: {
                        50: '#eef2ff',
                        100: '#dce3fa',
                        200: '#bac8f5',
                        300: '#93a8ee',
                        400: '#6b84e5',
                        500: '#4169E1',
                        600: '#3351c8',
                        700: '#2a41a4',
                        800: '#233584',
                        900: '#1c2968',
                        950: '#141d4a',
                    }
                }
            }
        }
    }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/intlTelInput.min.js"></script>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="tel"]').forEach(function(input) {
        if (input.dataset.itiInitialized) return;
        input.dataset.itiInitialized = '1';

        var hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = input.name;
        input.parentNode.appendChild(hiddenInput);

        var iti = window.intlTelInput(input, {
            initialCountry: 'ca',
            separateDialCode: true,
            hiddenInput: function() { return hiddenInput; },
            utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/utils.js',
            autoPlaceholder: 'polite',
        });

        input.removeAttribute('name');

        if (input.value) {
            iti.setNumber(input.value);
        }

        var nationalMaxLen = {
            us:10, ca:10, gb:10, ie:10, au:9,  nz:9,
            in:10, pk:10, bd:10, lk:10, np:10,
            de:11, fr:9,  it:10, es:9,  pt:9,  nl:9,  be:9,  ch:9,  at:10,
            pl:9,  cz:9,  sk:9,  hu:9,  ro:9,  gr:10, dk:8,  se:10, no:8,
            fi:10, ru:10, ua:10,
            jp:10, cn:11, kr:10, hk:8,  tw:9,  sg:8,  my:10, th:9,  vn:10,
            ph:10, id:11,
            ng:10, za:10, eg:10,
            sa:9,  ae:9,  tr:10, il:9,
            br:11, mx:10, ar:10, co:10, cl:9,  pe:9,
        };

        var digitLimit = 10;
        var settingNumber = false;

        function updateDigitLimit() {
            var cd = iti.getSelectedCountryData();
            if (cd && cd.iso2 && nationalMaxLen[cd.iso2]) {
                digitLimit = nationalMaxLen[cd.iso2];
            } else if (cd && cd.dialCode) {
                digitLimit = Math.max(7, 15 - String(cd.dialCode).length);
            }
        }
        updateDigitLimit();

        input.addEventListener('input', function() {
            if (settingNumber) return;
            var digits = input.value.replace(/\D/g, '');
            if (digits.length > digitLimit) {
                settingNumber = true;
                iti.setNumber(digits.slice(0, digitLimit));
                settingNumber = false;
            }
        });

        input.addEventListener('countrychange', function() {
            input.value = '';
            updateDigitLimit();
            input.focus();
        });
    });
});
</script>
</body>
</html>