<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Page;

class SitemapController extends Controller
{
    public function index()
    {
        $xml = $this->buildSitemap();

        file_put_contents(public_path('sitemap.xml'), $xml);

        return response($xml)->header('Content-Type', 'text/xml');
    }

    public function generate()
    {
        $xml = $this->buildSitemap();

        file_put_contents(public_path('sitemap.xml'), $xml);

        return response()->json(['success' => true, 'message' => 'Sitemap generated successfully']);
    }

    protected function buildSitemap(): string
    {
        $products = Product::where('is_active', true)->get(['slug', 'updated_at']);
        $categories = Category::where('is_active', true)->get(['slug', 'updated_at']);
        $pages = Page::where('is_active', true)->get(['slug', 'updated_at']);

        $staticUrls = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => route('shop'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => route('about'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => route('contact'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => route('our-company'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => route('privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('terms-conditions'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('custom.quote'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => route('software.development'), 'priority' => '0.6', 'changefreq' => 'monthly'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($staticUrls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$url['loc']}</loc>\n";
            $xml .= "    <priority>{$url['priority']}</priority>\n";
            $xml .= "    <changefreq>{$url['changefreq']}</changefreq>\n";
            $xml .= "  </url>\n";
        }

        foreach ($categories as $category) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . route('shop.category', $category->slug) . "</loc>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            if ($category->updated_at) {
                $xml .= '    <lastmod>' . $category->updated_at->tz('UTC')->toAtomString() . "</lastmod>\n";
            }
            $xml .= "  </url>\n";
        }

        foreach ($products as $product) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . route('shop.product', $product->slug) . "</loc>\n";
            $xml .= "    <priority>0.9</priority>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            if ($product->updated_at) {
                $xml .= '    <lastmod>' . $product->updated_at->tz('UTC')->toAtomString() . "</lastmod>\n";
            }
            $xml .= "  </url>\n";
        }

        foreach ($pages as $page) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . url('/page/' . $page->slug) . "</loc>\n";
            $xml .= "    <priority>0.6</priority>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            if ($page->updated_at) {
                $xml .= '    <lastmod>' . $page->updated_at->tz('UTC')->toAtomString() . "</lastmod>\n";
            }
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
