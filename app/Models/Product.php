<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'base_price',
        'sale_price',
        'sku',
        'image',
        'images',
        'is_active',
        'is_featured',
        'in_stock',
        'stock_quantity',
        'meta_title',
        'meta_description',
        'allow_artwork_upload',
        'artwork_instructions',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'in_stock' => 'boolean',
        'images' => 'array',
        'base_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'allow_artwork_upload' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }

    public function pricingOptions(): HasMany
    {
        return $this->hasMany(PricingOption::class)->orderBy('sort_order');
    }

    public function fileSetup(): HasOne
    {
        return $this->hasOne(ProductFileSetup::class);
    }

    public function templates(): HasMany
    {
        return $this->hasMany(ProductTemplate::class)->orderBy('sort_order');
    }

    public function getPriceAttribute()
    {
        return $this->sale_price ?? $this->base_price;
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getPrimaryImageAttribute()
    {
        if ($this->image) {
            return $this->image;
        }

        $primary = $this->productImages()->where('is_primary', true)->first();
        if ($primary && $primary->image) {
            return $primary->image;
        }

        $first = $this->productImages()->first();
        if ($first && $first->image) {
            return $first->image;
        }

        return '';
    }

    public function getCalculatedPriceAttribute(): float
    {
        $options = $this->pricingOptions;
        $salePrice = floatval($this->sale_price ?? 0);
        $basePrice = floatval($this->base_price ?? 0);
        
        if ($options->isNotEmpty()) {
            foreach ($options as $option) {
                if (!empty($option->prices) && isset($option->prices[0])) {
                    $optionPrice = floatval($option->prices[0]);
                    if ($salePrice > 0 && $salePrice < $optionPrice) {
                        return $salePrice;
                    }
                    return $optionPrice;
                }
            }
        }
        
        return $salePrice > 0 ? $salePrice : $basePrice;
    }
}
