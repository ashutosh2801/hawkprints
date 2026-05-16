<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'product_name',
        'variant_name',
        'price',
        'quantity',
        'subtotal',
        'pricing_options',
        'artwork_files',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'pricing_options' => 'array',
        'artwork_files' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function getPricingOptionsDisplayAttribute(): array
    {
        $options = $this->pricing_options ?? [];
        if (empty($options)) return [];

        $pricingOptions = PricingOption::whereIn('id', array_keys($options))->get()->keyBy('id');
        $display = [];

        foreach ($options as $optionId => $choiceIndex) {
            $option = $pricingOptions->get($optionId);
            if ($option) {
                $display[] = [
                    'name' => $option->option_name,
                    'choice' => $option->getChoiceByIndex((int) $choiceIndex),
                ];
            }
        }

        return $display;
    }
}
