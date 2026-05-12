@extends('layouts.app')

@section('title', 'Annual Returns - Five Rivers Print')
@section('meta_description', 'View Five Rivers Print annual returns and financial transparency documents.')

@section('content')
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8 lg:p-12">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold mb-4">Annual Returns</h1>
                <p class="text-gray-600 text-lg">Corporate filings and annual return information for Five Rivers Print Inc.</p>
            </div>

            <div class="prose prose-lg max-w-none text-gray-700">
                <p class="mb-6">
                    Five Rivers Print Inc. is a corporation registered under the laws of Canada. We are committed to maintaining transparency and complying with all applicable corporate filing requirements.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">About Annual Returns</h2>
                <p class="mb-4">
                    Annual returns are filings required by corporate law to keep the corporation in good standing. These filings provide updated information about the corporation, including its registered office address, directors, and share structure.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">Filing Information</h2>
                <div class="bg-gray-50 rounded-lg p-6 my-8">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="py-3 font-semibold pr-4">Corporation Name</td>
                                <td class="py-3">Five Rivers Print Inc.</td>
                            </tr>
                            <tr>
                                <td class="py-3 font-semibold pr-4">Jurisdiction</td>
                                <td class="py-3">Ontario, Canada</td>
                            </tr>
                            <tr>
                                <td class="py-3 font-semibold pr-4">Registered Office</td>
                                <td class="py-3">Brampton, Ontario</td>
                            </tr>
                            <tr>
                                <td class="py-3 font-semibold pr-4">Business Number</td>
                                <td class="py-3">Available upon request</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2 class="text-2xl font-bold mt-8 mb-4">Accessing Our Filings</h2>
                <p class="mb-4">
                    Corporate filings and annual returns are public records. You can access our filing history through:
                </p>
                <ul class="list-disc pl-6 mb-4 space-y-1">
                    <li><strong>Ontario Business Registry:</strong> Visit the <a href="https://www.ontario.ca/page/search-businesses-non-profits-co-operatives" class="text-blue-700 hover:underline" target="_blank" rel="noopener noreferrer">Ontario Business Registry</a></li>
                    <li><strong>Corporations Canada:</strong> For federal corporations, visit <a href="https://www.ic.gc.ca/app/scr/bsb-spc/srch-eng.html" class="text-blue-700 hover:underline" target="_blank" rel="noopener noreferrer">Corporations Canada</a></li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">Compliance</h2>
                <p class="mb-4">
                    Five Rivers Print Inc. maintains current compliance with all required annual filings. If you are a stakeholder and require documentation of our current filing status, please contact us directly.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">Contact Us</h2>
                <p class="mb-4">For inquiries regarding our annual returns or corporate filings:</p>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <ul class="space-y-2">
                        <li><strong>Email:</strong> info@fiveriversprint.ca</li>
                        <li><strong>Phone:</strong> 905-744-0013</li>
                        <li><strong>Address:</strong> Brampton, Ontario, Canada</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
