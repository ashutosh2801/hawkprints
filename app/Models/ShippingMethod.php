<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'estimated_days',
        'is_active',
        'min_order_amount',
        'max_order_amount',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'float',
        'min_order_amount' => 'float',
        'max_order_amount' => 'float',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function isAvailableForAmount(float $amount): bool
    {
        if ($this->min_order_amount && $amount < $this->min_order_amount) {
            return false;
        }
        if ($this->max_order_amount && $amount > $this->max_order_amount) {
            return false;
        }
        return true;
    }
}