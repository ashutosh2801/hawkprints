@extends('layouts.app')

@section('title', 'Privacy Policy - Five Rivers Print')
@section('meta_description', 'Read the Five Rivers Print privacy policy to understand how we collect, use, and protect your personal information.')

@section('content')
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8 lg:p-12">
            <h1 class="text-4xl font-bold mb-8">Privacy Policy</h1>
            <p class="text-gray-600 mb-6">Last updated: {{ date('F d, Y') }}</p>

            <div class="prose prose-lg max-w-none text-gray-700">
                <p class="mb-6">Five Rivers Print ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or place an order.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">1. Information We Collect</h2>
                <h3 class="text-xl font-semibold mt-6 mb-2">Personal Information</h3>
                <p class="mb-4">We may collect personal information that you voluntarily provide, including:</p>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li>Name and email address</li>
                    <li>Phone number</li>
                    <li>Billing and shipping addresses</li>
                    <li>Payment information (processed securely through Stripe)</li>
                    <li>Artwork files and design preferences</li>
                    <li>Account credentials (if you create an account)</li>
                </ul>

                <h3 class="text-xl font-semibold mt-6 mb-2">Automatically Collected Information</h3>
                <p class="mb-4">When you visit our website, certain information may be collected automatically, including:</p>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li>IP address and browser type</li>
                    <li>Device information and operating system</li>
                    <li>Pages visited and time spent on the site</li>
                    <li>Referring website or search engine</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">2. How We Use Your Information</h2>
                <p class="mb-4">We use the information we collect to:</p>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li>Process and fulfill your orders</li>
                    <li>Communicate with you about your orders, accounts, or inquiries</li>
                    <li>Send promotional emails with your consent</li>
                    <li>Improve our website, products, and services</li>
                    <li>Prevent fraud and ensure security</li>
                    <li>Comply with legal obligations</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">3. Sharing Your Information</h2>
                <p class="mb-4">We do not sell, trade, or rent your personal information to third parties. We may share your information only with:</p>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li><strong>Payment processors</strong> (Stripe) to process transactions securely</li>
                    <li><strong>Shipping carriers</strong> to deliver your orders</li>
                    <li><strong>Service providers</strong> who assist in operating our website and business</li>
                    <li><strong>Law enforcement</strong> when required by law or to protect our rights</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">4. Data Security</h2>
                <p class="mb-4">We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. All payment transactions are encrypted using SSL technology.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">5. Data Retention</h2>
                <p class="mb-4">We retain your personal information for as long as necessary to fulfill the purposes outlined in this policy, unless a longer retention period is required by law.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">6. Your Rights</h2>
                <p class="mb-4">Depending on your location, you may have the right to:</p>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li>Access the personal information we hold about you</li>
                    <li>Request correction of inaccurate information</li>
                    <li>Request deletion of your personal information</li>
                    <li>Opt out of marketing communications</li>
                    <li>Lodge a complaint with a data protection authority</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">7. Cookies</h2>
                <p class="mb-4">We use cookies and similar technologies to enhance your browsing experience, remember your preferences, and analyze website traffic. You can control cookie settings through your browser preferences.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">8. Third-Party Links</h2>
                <p class="mb-4">Our website may contain links to third-party websites. We are not responsible for the privacy practices of these external sites. We encourage you to review their privacy policies.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">9. Children's Privacy</h2>
                <p class="mb-4">Our website is not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">10. Changes to This Policy</h2>
                <p class="mb-4">We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page with an updated revision date.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">11. Contact Us</h2>
                <p class="mb-4">If you have questions or concerns about this Privacy Policy, please contact us:</p>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li><strong>Email:</strong> info@fiveriversprint.ca</li>
                    <li><strong>Phone:</strong> 905-744-0013</li>
                    <li><strong>Address:</strong> Brampton, Ontario, Canada</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
