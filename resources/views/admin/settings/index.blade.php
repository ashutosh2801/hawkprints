@extends('admin.layout')

@section('page-title', 'Settings')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
        @endif
        
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf
            
            <h2 class="text-xl font-bold mb-6">Site Branding</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo (Image)</label>
                    <div class="mt-1 flex items-start gap-4">
                        <div id="logo-preview" class="h-16 w-auto border rounded overflow-hidden flex items-center justify-center bg-gray-50 {{ !$settings['logo'] ? 'p-4' : '' }}">
                            @if($settings['logo'])
                            <img src="{{ $settings['logo'] }}" alt="Logo" class="h-16 w-auto object-contain">
                            @else
                            <span class="text-gray-400 text-xs">No logo</span>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <button type="button" onclick="selectFromLibrary('logo')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Choose from Library
                            </button>
                            <input type="hidden" name="logo_url" id="logo-url" value="{{ $settings['logo'] }}">
                        </div>
                    </div>
                    <small class="text-gray-500">Recommended size: 200x60px</small>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Favicon (ICO/PNG)</label>
                    <div class="mt-1 flex items-start gap-4">
                        <div id="favicon-preview" class="h-10 w-10 border rounded overflow-hidden flex items-center justify-center bg-gray-50 {{ !$settings['favicon'] ? 'p-2' : '' }}">
                            @if($settings['favicon'])
                            <img src="{{ $settings['favicon'] }}" alt="Favicon" class="h-10 w-10 object-contain">
                            @else
                            <span class="text-gray-400 text-xs">No favicon</span>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <button type="button" onclick="selectFromLibrary('favicon')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Choose from Library
                            </button>
                            <input type="hidden" name="favicon_url" id="favicon-url" value="{{ $settings['favicon'] }}">
                        </div>
                    </div>
                    <small class="text-gray-500">Recommended size: 32x32px or 16x16px</small>
                </div>
            </div>
            
            <hr class="my-8">
            
            <h2 class="text-xl font-bold mb-6">Home Page SEO</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label>
                    <input type="text" name="seo_title" value="{{ $settings['seo_title'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="{{ $settings['company_name'] }} - Your Title Here">
                    <small class="text-gray-500">Recommended: 50-60 characters</small>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">SEO Description</label>
                    <textarea name="seo_description" rows="3" maxlength="160"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Your meta description here...">{{ $settings['seo_description'] }}</textarea>
                    <small class="text-gray-500"><span id="descCount">{{ strlen($settings['seo_description']) }}</span>/160 characters</small>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">SEO Keywords</label>
                    <input type="text" name="seo_keywords" value="{{ $settings['seo_keywords'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="printing, business cards, banners, sublimation...">
                    <small class="text-gray-500">Separate keywords with commas</small>
                </div>
            </div>
            
            <hr class="my-8">

            <h2 class="text-xl font-bold mb-6">Open Graph / Social Sharing</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Default OG Image (1200x630px)</label>
                    <div class="mt-1 flex items-start gap-4">
                        <div id="og-image-preview" class="h-24 w-48 border rounded overflow-hidden flex items-center justify-center bg-gray-50 {{ !$settings['og_image'] ? 'p-4' : '' }}">
                            @if($settings['og_image'])
                            <img src="{{ $settings['og_image'] }}" alt="OG Image" class="h-full w-full object-cover">
                            @else
                            <span class="text-gray-400 text-xs text-center">No OG image set<br><small>1200x630px recommended</small></span>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <button type="button" onclick="selectFromLibrary('og-image')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Choose from Library
                            </button>
                            <input type="hidden" name="og_image_url" id="og-image-url" value="{{ $settings['og_image'] }}">
                        </div>
                    </div>
                    <small class="text-gray-500">Used when pages don't specify their own image. 1200x630px recommended.</small>
                </div>
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Facebook App ID</label>
                        <input type="text" name="facebook_app_id" value="{{ $settings['facebook_app_id'] ?? '' }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="1234567890">
                        <small class="text-gray-500">Used for Facebook sharing insights</small>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Twitter/X Handle</label>
                        <input type="text" name="twitter_handle" value="{{ $settings['twitter_handle'] ?? '' }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="@yourhandle">
                        <small class="text-gray-500">Twitter card attribution (e.g. @fiveriversprint)</small>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <h3 class="text-lg font-bold mb-2">Sitemap</h3>
                <p class="text-sm text-gray-600 mb-4">Generate the sitemap.xml file for search engines. Visit <a href="{{ url('/sitemap.xml') }}" class="text-blue-600 hover:underline" target="_blank">{{ url('/sitemap.xml') }}</a> to view it.</p>
                <button type="button" onclick="generateSitemap()" id="sitemapBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                    Regenerate Sitemap
                </button>
                <span id="sitemapStatus" class="ml-3 text-sm"></span>
            </div>

            <hr class="my-8">

            <h2 class="text-xl font-bold mb-6">Image Storage</h2>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Storage Driver</label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="image_storage" value="local" {{ $settings['image_storage'] === 'local' ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="font-medium">Local Storage</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="image_storage" value="s3" {{ $settings['image_storage'] === 's3' ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="font-medium">AWS S3</span>
                    </label>
                </div>
            </div>

            <div id="aws-settings" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8" style="{{ $settings['image_storage'] === 's3' ? '' : 'display: none;' }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">AWS Access Key ID</label>
                    <input type="text" name="aws_access_key_id" value="{{ $settings['aws_access_key_id'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="AKIA...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">AWS Secret Access Key</label>
                    <input type="password" name="aws_secret_access_key"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Leave blank to keep current">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">AWS Region</label>
                    <input type="text" name="aws_default_region" value="{{ $settings['aws_default_region'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="us-east-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">S3 Bucket</label>
                    <input type="text" name="aws_bucket" value="{{ $settings['aws_bucket'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="my-bucket">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">S3 URL (optional)</label>
                    <input type="text" name="aws_url" value="{{ $settings['aws_url'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://my-bucket.s3.amazonaws.com">
                    <small class="text-gray-500">If using a custom CDN or bucket URL, enter it here. Leave blank for default.</small>
                </div>
            </div>

            <script>
            document.querySelectorAll('input[name="image_storage"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    document.getElementById('aws-settings').style.display = this.value === 's3' ? '' : 'none';
                });
            });
            </script>

            <hr class="my-8">

            <h2 class="text-xl font-bold mb-6">Social Media &amp; Analytics</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                    <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://facebook.com/yourpage">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Twitter/X URL</label>
                    <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://twitter.com/yourhandle">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                    <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://instagram.com/yourhandle">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                    <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://linkedin.com/company/yourpage">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tracking Code</label>
                    <textarea name="tracking_code" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                        placeholder="Google Analytics or other tracking code (including &lt;script&gt; tags)">{{ $settings['tracking_code'] ?? '' }}</textarea>
                    <small class="text-gray-500">Will be inserted just before closing &lt;/head&gt; tag. Use full script tags.</small>
                </div>
            </div>

            <hr class="my-8">

            <h2 class="text-xl font-bold mb-6">Stripe Payment Settings</h2>
            
            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="stripe_enabled" value="1" {{ $settings['stripe_enabled'] === '1' ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="font-medium">Enable Stripe Payment</span>
                </label>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Publishable Key</label>
                    <input type="text" name="stripe_key" value="{{ $settings['stripe_key'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="pk_test_...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Secret Key</label>
                    <input type="password" name="stripe_secret" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="sk_test_...">
                    <small class="text-gray-500">Leave blank to keep current secret</small>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Webhook Secret</label>
                    <input type="password" name="stripe_webhook_secret" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="whsec_...">
                </div>
            </div>
            
            <hr class="my-8">
            
            <h2 class="text-xl font-bold mb-6">Payment Methods</h2>
            
            <div class="space-y-6 mb-8">
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="cod_enabled" value="1" {{ $settings['cod_enabled'] === '1' ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        <span class="font-medium">Enable Cash on Delivery (COD)</span>
                    </label>
                    <p class="text-sm text-gray-500 ml-8">Allow customers to pay upon delivery</p>
                </div>
            </div>
            
            <hr class="my-8">
            
            <h2 class="text-xl font-bold mb-6">Company Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                    <input type="text" name="company_name" value="{{ $settings['company_name'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="company_email" value="{{ $settings['company_email'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="company_phone" value="{{ $settings['company_phone'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tax Rate (%)</label>
                    <input type="number" name="tax_rate" value="{{ $settings['tax_rate'] }}" step="0.01"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Cost ($)</label>
                    <input type="number" name="shipping_cost" value="{{ $settings['shipping_cost'] }}" step="0.01"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="company_address" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 wysiwyg">{{ $settings['company_address'] }}</textarea>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var descTextarea = document.querySelector('textarea[name="seo_description"]');
    var descCount = document.getElementById('descCount');
    if (descTextarea && descCount) {
        descTextarea.addEventListener('input', function() {
            descCount.textContent = this.value.length;
        });
    }
});
</script>
<script>
function generateSitemap() {
    const btn = document.getElementById('sitemapBtn');
    const status = document.getElementById('sitemapStatus');
    btn.disabled = true;
    btn.textContent = 'Generating...';
    status.textContent = '';
    fetch('/admin/generate-sitemap', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            status.className = 'ml-3 text-sm text-green-600';
            status.textContent = 'Sitemap generated!';
        } else {
            status.className = 'ml-3 text-sm text-red-600';
            status.textContent = 'Failed to generate sitemap.';
        }
    })
    .catch(() => {
        status.className = 'ml-3 text-sm text-red-600';
        status.textContent = 'Error generating sitemap.';
    })
    .finally(() => {
        btn.disabled = false;
        btn.textContent = 'Regenerate Sitemap';
    });
}

function selectFromLibrary(prefix) {
    openMediaLibrary({
        mode: 'single',
        callback: function(ids) {
            var img = mediaLibraryState.allImages.find(i => i.id === ids[0]);
            if (img) {
                document.getElementById(prefix + '-url').value = img.url;
                var suffix = '';
                if (prefix === 'logo') suffix = 'Logo" class="h-16 w-auto object-contain';
                if (prefix === 'favicon') suffix = 'Favicon" class="h-10 w-10 object-contain';
                if (prefix === 'og-image') suffix = 'OG Image" class="h-full w-full object-cover';
                document.getElementById(prefix + '-preview').innerHTML = '<img src="' + img.url + '" alt="' + suffix + '">';
            }
        }
    });
}
</script>

@include('admin.partials.media-library')
@endsection