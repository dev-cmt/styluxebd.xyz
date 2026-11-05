<?php

namespace App;

use App\Admin;
use App\Order;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderActivity extends Model
{
    protected $fillable = [
        'order_id',
        'causer_type',
        'causer_id',
        'activity_type',
        'field',
        'old_value',
        'new_value',
        'text',
        'comment',
        'batch_uuid',
        'ip_address',
    ];

    /**
     * এই টেবিলে খুব বেশি insert হবে, update হয় না বললেই চলে,
     * তাই timestamps সহ রেখে দেওয়া হলো audit trail-এর জন্য।
     */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * causer_type/causer_id না থাকলে ধরে নেওয়া হবে এটা সিস্টেম (console/cron/queue) থেকে হয়েছে।
     */
    public function getCauserNameAttribute(): string
    {
        if (! $this->causer) {
            return 'System';
        }

        if ($this->causer instanceof Admin || $this->causer instanceof User) {
            return $this->causer->name ?? ('#' . $this->causer_id);
        }

        return class_basename($this->causer_type) . ' #' . $this->causer_id;
    }
}
