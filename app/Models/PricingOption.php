<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PricingOption extends Model
{
    protected $fillable = [
        'product_id',
        'option_name',
        'option_type',
        'choices',
        'prices',
        'is_required',
        'sort_order',
    ];

    protected $casts = [
        'choices' => 'array',
        'prices' => 'array',
        'is_required' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceByIndex($index)
    {
        $prices = $this->prices;
        return $prices[$index] ?? $prices[0] ?? 0;
    }

    public function getChoiceByIndex($index)
    {
        $choices = $this->choices;
        return $choices[$index] ?? $choices[0] ?? '';
    }
}