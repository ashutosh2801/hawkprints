<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageSection extends Model
{
    protected $fillable = [
        'key',
        'title',
        'description',
        'is_active',
        'sort_order',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public const SECTIONS = [
        'hero' => [
            'title' => 'Hero Slider',
            'description' => 'Main banner slider at the top of the page',
            'partial' => 'front.partials.hero',
        ],
        'categories' => [
            'title' => 'Shop Favourites',
            'description' => 'Grid of popular product categories',
            'partial' => 'front.partials.categories',
        ],
        'featured-products' => [
            'title' => 'Featured Products',
            'description' => 'Showcase featured products',
            'partial' => 'front.partials.featured-products',
        ],
        'explore-categories' => [
            'title' => 'Explore Categories',
            'description' => 'Browse all product categories',
            'partial' => 'front.partials.explore-categories',
        ],
        'all-categories' => [
            'title' => 'All Categories',
            'description' => 'Full list of product categories',
            'partial' => 'front.partials.all-categories',
        ],
        'about' => [
            'title' => 'About Us',
            'description' => 'About section with company info',
            'partial' => 'front.partials.about',
        ],
        'testimonials' => [
            'title' => 'Testimonials',
            'description' => 'Customer testimonials carousel',
            'partial' => 'front.partials.testimonials',
        ],
        'clients' => [
            'title' => 'Our Clients',
            'description' => 'Client logos and brand showcase',
            'partial' => 'front.partials.clients',
        ],
        'new-arrivals' => [
            'title' => 'New Arrivals',
            'description' => 'Latest products section',
            'partial' => 'front.partials.new-arrivals',
        ],
    ];
}
