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
        'input_type',
        'choices',
        'prices',
        'conditions',
        'is_required',
        'sort_order',
    ];

    protected $casts = [
        'choices' => 'array',
        'prices' => 'array',
        'conditions' => 'array',
        'is_required' => 'boolean',
    ];

    public function getInputTypeAttribute($value)
    {
        return $value ?? 'dropdown';
    }

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