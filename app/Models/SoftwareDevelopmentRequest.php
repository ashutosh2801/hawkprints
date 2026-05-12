<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareDevelopmentRequest extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'company', 'service',
        'budget', 'message', 'status', 'admin_notes', 'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'budget' => 'decimal:2',
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
