<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id', 'sort_order', 'is_active', 'type', 'reference_id'];

    protected $casts = ['is_active' => 'boolean'];

    protected $appends = ['effective_slug', 'effective_name'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    public static function getMenuItems()
    {
        return self::where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();
    }

    public function getEffectiveSlugAttribute()
    {
        if ($this->type === 'category' && $this->reference_id) {
            $category = Category::find($this->reference_id);
            return $category ? '/shop/category/' . $category->slug : $this->slug;
        }
        if ($this->type === 'product' && $this->reference_id) {
            $product = Product::find($this->reference_id);
            return $product ? '/shop/product/' . $product->slug : $this->slug;
        }
        return $this->slug;
    }

    public function getEffectiveNameAttribute()
    {
        if ($this->type === 'category' && $this->reference_id) {
            $category = Category::find($this->reference_id);
            return $category ? $category->name : $this->name;
        }
        if ($this->type === 'product' && $this->reference_id) {
            $product = Product::find($this->reference_id);
            return $product ? $product->name : $this->name;
        }
        return $this->name;
    }
}