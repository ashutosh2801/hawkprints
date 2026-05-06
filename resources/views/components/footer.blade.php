@php
    $companyName = \App\Models\Setting::get('company_name', 'Hawk Prints');
    $companyEmail = \App\Models\Setting::get('company_email', 'info@hawkprints.ca');
    $companyPhone = \App\Models\Setting::get('company_phone', '905-744-0013');
    $companyAddress = \App\Models\Setting::get('company_address', 'Brampton, Ontario, Canada');
@endphp

<footer class="bg-gray-900 text-white">
    <!-- Main Footer -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12">
            <!-- Brand Column -->
            <div class="lg:col-span-4">
                <div class="mb-6">
                    @if($logo = \App\Models\Setting::get('logo'))
                        <img src="{{ $logo }}" alt="{{ $companyName }}" class="h-10 w-auto object-contain brightness-200">
                    @else
                        <div class="text-2xl font-bold tracking-tight">Hawk<span class="text-blue-500">Prints</span></div>
                    @endif
                </div>
                <p class="text-gray-400 mb-6 leading-relaxed max-w-sm">Premium quality printing services in Brampton. We may not be the cheapest, but we deliver the best quality.</p>
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
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="leading-relaxed">{!! nl2br(e($companyAddress)) !!}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="lg:col-span-2">
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-6">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('shop') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Shop All</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors text-sm">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Contact</a></li>
                    <li><a href="/custom-quote" class="text-gray-400 hover:text-white transition-colors text-sm">Custom Quote</a></li>
                </ul>
            </div>

            <!-- Help -->
            <div class="lg:col-span-2">
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-6">Help</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('customer.login') }}" class="text-gray-400 hover:text-white transition-colors text-sm">My Account</a></li>
                    <li><a href="{{ route('orders') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Order Tracking</a></li>
                    <li><a href="{{ route('terms-conditions') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Terms & Conditions</a></li>
                    <li><a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Privacy Policy</a></li>
                </ul>
            </div>

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

                <!-- Social Links -->
                <div class="mt-8">
                    <h5 class="text-sm font-medium text-gray-300 mb-4">Follow Us</h5>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047v-2.642c0-3.007 1.802-4.658 4.555-4.658 1.312 0 2.686.082 2.686.082v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-br hover:from-purple-600 hover:to-pink-500 rounded-lg flex items-center justify-center transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.584.07-4.849.151-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.007 0-.014.001-.021.006-1.605 1.307-2.766 2.801-3.574 4.539-.391.942-.586 1.917-.586 2.926 0 .082.003.163.008.244.003-.002.006-.005.01-.007 2.446-1.433 4.147-3.626 4.168-3.684-.011-.055-.034-.113-.034-.181.001-.054.018-.106.019-.16.001-.015-.001-.03-.004-.044z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-500 rounded-lg flex items-center justify-center transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.37-4.42 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-3.34V9.4a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.07z"/></svg>
                        </a>
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
                    <img src="https://hawkprints.ca/wp-content/uploads/2023/01/visa.jpg" alt="Visa" class="h-6 rounded">
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
