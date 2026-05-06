@extends('layouts.app')

@section('title', 'Terms & Conditions - Hawk Prints')

@section('content')
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8 lg:p-12">
            <h1 class="text-4xl font-bold mb-8">Terms & Conditions</h1>
            <p class="text-gray-600 mb-6">Last updated: {{ date('F d, Y') }}</p>

            <div class="prose prose-lg max-w-none text-gray-700">
                <p class="mb-6">Please read these Terms & Conditions carefully before using our website and services. By accessing or using hawkprints.ca, you agree to be bound by these terms.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">1. General</h2>
                <p class="mb-4">These Terms & Conditions govern your use of our website and the purchase of our printing products and services. We reserve the right to modify these terms at any time. Continued use of our services constitutes acceptance of any changes.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">2. Orders & Payments</h2>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li>All orders are subject to acceptance and availability</li>
                    <li>Prices are listed in Canadian dollars (CAD) unless otherwise stated</li>
                    <li>Payment must be made in full before order processing begins</li>
                    <li>We accept payments via credit card (through Stripe) and cash on delivery where available</li>
                    <li>We reserve the right to refuse or cancel any order at our discretion</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">3. Artwork & Design</h2>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li>Customers are responsible for providing print-ready artwork files</li>
                    <li>Accepted file formats: PDF, AI, PSD, PNG, JPG/JPEG</li>
                    <li>Files must meet minimum resolution requirements (300 DPI recommended)</li>
                    <li>We are not responsible for errors in customer-supplied artwork</li>
                    <li>By submitting artwork, you confirm you have the rights to use all content</li>
                    <li>We may contact you regarding artwork issues before printing</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">4. Production & Turnaround</h2>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li>Production times are estimates and may vary based on order volume</li>
                    <li>Rush orders may be available for an additional fee</li>
                    <li>Production begins only after payment is received and artwork is approved</li>
                    <li>We are not liable for delays caused by factors beyond our control</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">5. Shipping & Delivery</h2>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li>Shipping costs are calculated at checkout based on selected method</li>
                    <li>Delivery times are estimates and not guaranteed</li>
                    <li>Risk of loss passes to the buyer upon delivery to the carrier</li>
                    <li>Customers are responsible for providing accurate shipping addresses</li>
                    <li>We are not responsible for delays caused by shipping carriers</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">6. Returns & Refunds</h2>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li>Due to the custom nature of printed products, all sales are generally final</li>
                    <li>Refunds may be issued if the product is defective or does not match the approved proof</li>
                    <li>Reprints or refunds will not be provided for errors in customer-supplied artwork</li>
                    <li>Return requests must be submitted within 7 days of delivery</li>
                    <li>Contact us at info@hawkprints.ca to initiate a return or refund</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">7. Intellectual Property</h2>
                <p class="mb-4">All content on this website, including but not limited to text, graphics, logos, and images, is the property of Hawk Prints and is protected by intellectual property laws. You may not reproduce or distribute any content without our prior written consent.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">8. Limitation of Liability</h2>
                <p class="mb-4">Hawk Prints shall not be liable for any indirect, incidental, special, or consequential damages arising from the use of our website or products. Our total liability shall not exceed the amount paid for the specific product or service in question.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">9. User Accounts</h2>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li>You are responsible for maintaining the confidentiality of your account credentials</li>
                    <li>You agree to provide accurate and complete information when creating an account</li>
                    <li>You are responsible for all activities that occur under your account</li>
                    <li>We reserve the right to suspend or terminate accounts that violate these terms</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">10. Governing Law</h2>
                <p class="mb-4">These terms are governed by the laws of the Province of Ontario and the laws of Canada applicable therein. Any disputes shall be resolved in the courts of Ontario.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">11. Contact Information</h2>
                <p class="mb-4">For questions about these Terms & Conditions, please contact us:</p>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li><strong>Email:</strong> info@hawkprints.ca</li>
                    <li><strong>Phone:</strong> 905-744-0013</li>
                    <li><strong>Address:</strong> Brampton, Ontario, Canada</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
