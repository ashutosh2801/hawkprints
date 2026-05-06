<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'subject',
        'body',
        'is_active',
        'send_to_customer',
        'send_to_admin',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'send_to_customer' => 'boolean',
        'send_to_admin' => 'boolean',
    ];

    public static function getSlugs()
    {
        return [
            'order_confirmation',
            'order_admin_notification',
        ];
    }
}