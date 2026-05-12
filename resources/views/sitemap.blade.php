<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($staticUrls as $url)
    <url>
        <loc>{{ $url['loc'] }}</loc>
        <priority>{{ $url['priority'] }}</priority>
        <changefreq>{{ $url['changefreq'] }}</changefreq>
    </url>
    @endforeach

    @foreach($categories as $category)
    <url>
        <loc>{{ route('shop.category', $category->slug) }}</loc>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
        @if($category->updated_at)
        <lastmod>{{ $category->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        @endif
    </url>
    @endforeach

    @foreach($products as $product)
    <url>
        <loc>{{ route('shop.product', $product->slug) }}</loc>
        <priority>0.9</priority>
        <changefreq>weekly</changefreq>
        @if($product->updated_at)
        <lastmod>{{ $product->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        @endif
    </url>
    @endforeach

    @foreach($pages as $page)
    <url>
        <loc>{{ url('/page/' . $page->slug) }}</loc>
        <priority>0.6</priority>
        <changefreq>monthly</changefreq>
        @if($page->updated_at)
        <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        @endif
    </url>
    @endforeach
</urlset>
