<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'template',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
