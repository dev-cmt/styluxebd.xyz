<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderNote extends Model
{
    protected $fillable = ['order_id', 'note', 'user_id', 'user_type'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Dynamic Author Name Fetcher
    public function getAuthorNameAttribute(): string
    {
        if ($this->user_type === 'staff') {
            return $this->admin ? $this->admin->name : 'Staff/System';
        }
        return $this->customer ? $this->customer->name : 'Customer';
    }
}
