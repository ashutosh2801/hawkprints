@php
    $companyName = \App\Models\Setting::get('company_name', 'Five Rivers Print');
    $companyEmail = \App\Models\Setting::get('company_email', 'info@fiveriversprint.ca');
    $companyPhone = \App\Models\Setting::get('company_phone', '905-744-0013');
    $companyAddress = \App\Models\Setting::get('company_address', 'Brampton, Ontario, Canada');
    $footerMenuItems = \App\Models\MenuItem::where('location', 'footer')
        ->whereNull('parent_id')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->with(['children' => function ($q) {
            $q->where('is_active', true)->orderBy('sort_order');
        }])
        ->get();
@endphp

<footer class="bg-gray-900 text-white">
    <!-- Main Footer -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12">
            <!-- Brand Column -->
            <div class="lg:col-span-4">
                <!-- <div class="mb-6">
                    @if($logo = \App\Models\Setting::get('logo'))
                        <img src="{{ $logo }}" alt="{{ $companyName }}" class="h-10 w-auto object-contain brightness-200">
                    @else
                        <div class="text-2xl font-bold tracking-tight">Five Rivers Print</div>
                    @endif
                </div> -->
                <p class="text-gray-400 mb-6 leading-relaxed max-w-sm">We offer a wide selection of brand-name apparel that's primed for personalization. selection of brand-name.</p>
                <div class="space-y-3 text-sm text-gray-400">
                    <a href="tel:{{ $companyPhone }}" class="flex items-center gap-3 hover:text-white transition-colors group">
                        <div class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        {{ $companyPhone }}
                    </a>
                    <a href="mailto:{{ $companyEmail }}" class="flex items-center gap-3 hover:text-white transition-colors group">
                        <div class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        {{ $companyEmail }}
                    </a>
                    <!-- <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="leading-relaxed">{!! nl2br(e($companyAddress)) !!}</span>
                    </div> -->
                </div>
            </div>

            <!-- Footer Menu Columns -->
            @foreach($footerMenuItems as $section)
            <div class="lg:col-span-2">
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-6">{{ $section->effective_name }}</h4>
                @if($section->children->count() > 0)
                <ul class="space-y-3">
                    @foreach($section->children as $link)
                    <li><a href="{{ $link->effective_slug }}" class="text-gray-400 hover:text-white transition-colors text-sm">{{ $link->effective_name }}</a></li>
                    @endforeach
                </ul>
                @endif
            </div>
            @endforeach

            <!-- Newsletter -->
            <div class="lg:col-span-4">
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-2">Newsletter</h4>
                <p class="text-gray-400 text-sm mb-6">Get exclusive offers and updates delivered to your inbox.</p>
                <form id="newsletterForm" class="space-y-3">
                    <div class="flex gap-2">
                        <input type="email" name="email" id="newsletterEmail" placeholder="Enter your email" class="flex-1 px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
                        <button type="submit" id="newsletterBtn" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl font-medium text-sm transition-colors duration-300 whitespace-nowrap">
                            Subscribe
                        </button>
                    </div>
                    <p id="newsletterMessage" class="text-sm hidden"></p>
                </form>

                @php
                    $socialFacebook = \App\Models\Setting::get('social_facebook', '');
                    $socialTwitter = \App\Models\Setting::get('social_twitter', '');
                    $socialInstagram = \App\Models\Setting::get('social_instagram', '');
                    $socialLinkedin = \App\Models\Setting::get('social_linkedin', '');
                @endphp
                <!-- Social Links -->
                <div class="mt-8">
                    <h5 class="text-sm font-medium text-gray-300 mb-4">Follow Us</h5>
                    <div class="flex gap-3">
                        @if($socialFacebook)
                        <a href="{{ $socialFacebook }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors duration-300" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047v-2.642c0-3.007 1.802-4.658 4.555-4.658 1.312 0 2.686.082 2.686.082v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        @endif
                        @if($socialInstagram)
                        <a href="{{ $socialInstagram }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-br hover:from-purple-600 hover:to-pink-500 rounded-lg flex items-center justify-center transition-colors duration-300" aria-label="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.584.07-4.849.151-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.007 0-.014.001-.021.006-1.605 1.307-2.766 2.801-3.574 4.539-.391.942-.586 1.917-.586 2.926 0 .082.003.163.008.244.003-.002.006-.005.01-.007 2.446-1.433 4.147-3.626 4.168-3.684-.011-.055-.034-.113-.034-.181.001-.054.018-.106.019-.16.001-.015-.001-.03-.004-.044z"/></svg>
                        </a>
                        @endif
                        @if($socialTwitter)
                        <a href="{{ $socialTwitter }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-800 hover:bg-blue-500 rounded-lg flex items-center justify-center transition-colors duration-300" aria-label="Twitter/X">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        @endif
                        @if($socialLinkedin)
                        <a href="{{ $socialLinkedin }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-800 hover:bg-blue-700 rounded-lg flex items-center justify-center transition-colors duration-300" aria-label="LinkedIn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-800">
        <div class="container mx-auto px-4 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-gray-500 text-sm">{{ $companyName }} Inc. &copy; {{ date('Y') }} All rights reserved.</p>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1.5 text-gray-500 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Secure checkout powered by Stripe
                </div>
                <div class="flex items-center gap-2">
                    <img src="https://fiveriversprint.ca/wp-content/uploads/2023/01/visa.jpg" alt="Visa" class="h-6 rounded">
                    <div class="w-8 h-5 bg-gray-700 rounded flex items-center justify-center">
                        <span class="text-[8px] font-bold text-gray-300">MC</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletterForm');
    const emailInput = document.getElementById('newsletterEmail');
    const btn = document.getElementById('newsletterBtn');
    const message = document.getElementById('newsletterMessage');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const email = emailInput.value.trim();
            if (!email) return;

            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin inline w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            message.classList.add('hidden');

            fetch('{{ route("newsletter.subscribe") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                message.textContent = data.message;
                message.classList.remove('hidden');

                if (data.success) {
                    message.className = 'text-sm text-green-400';
                    emailInput.value = '';
                } else {
                    message.className = 'text-sm text-red-400';
                }
            })
            .catch(error => {
                message.textContent = 'Something went wrong. Please try again.';
                message.className = 'text-sm text-red-400';
                message.classList.remove('hidden');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Subscribe';
            });
        });
    }
});
</script>
@endpush
