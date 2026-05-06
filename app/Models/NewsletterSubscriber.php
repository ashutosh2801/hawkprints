<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $table = 'newsletter_subscribers';

    protected $fillable = [
        'email',
        'is_active',
        'subscribed_at',
        'unsubscribed_at',
        'unsubscribe_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    public static function subscribe(string $email): array
    {
        $subscriber = self::where('email', $email)->first();

        if ($subscriber && $subscriber->is_active) {
            return ['success' => false, 'message' => 'You are already subscribed.'];
        }

        if ($subscriber) {
            $subscriber->update([
                'is_active' => true,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]);
            return ['success' => true, 'message' => 'Welcome back! You have been resubscribed.'];
        }

        self::create([
            'email' => $email,
            'is_active' => true,
            'subscribed_at' => now(),
            'unsubscribe_token' => Str::uuid(),
        ]);

        return ['success' => true, 'message' => 'Thank you for subscribing!'];
    }

    public static function unsubscribeByToken(string $token): array
    {
        $subscriber = self::where('unsubscribe_token', $token)->first();

        if (!$subscriber) {
            return ['success' => false, 'message' => 'Invalid unsubscribe link.'];
        }

        if (!$subscriber->is_active) {
            return ['success' => false, 'message' => 'You are already unsubscribed.'];
        }

        $subscriber->update([
            'is_active' => false,
            'unsubscribed_at' => now(),
        ]);

        return ['success' => true, 'message' => 'You have been unsubscribed successfully.'];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
