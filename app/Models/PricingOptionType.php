<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PricingOptionType extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pricingOptions(): HasMany
    {
        return $this->hasMany(PricingOption::class, 'option_type', 'name');
    }

    public static function getActiveTypes()
    {
        return self::where('is_active', true)->orderBy('sort_order')->get();
    }

    public static function createType($name, $icon = null)
    {
        return self::create([
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'icon' => $icon,
        ]);
    }
}