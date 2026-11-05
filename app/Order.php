<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    // source 1 = web, 2 = api

    // Source Configuration with Name and Color/Badge Class
    // Order.php Model-এ
    public const SOURCE = [
        'website'    => ['name' => 'Website', 'color' => 'bg-teal text-teal-fg'],
        'whatsapp'   => ['name' => 'WhatsApp', 'color' => 'bg-green text-green-fg'],
        'page'       => ['name' => 'Page', 'color' => 'bg-info text-info-fg'],
        'call'       => ['name' => 'Call', 'color' => 'bg-danger text-danger-fg'],
        'instagram'  => ['name' => 'Instagram', 'color' => 'bg-pink text-pink-fg'],
        'tiktok'     => ['name' => 'TikTok', 'color' => 'bg-dark text-dark-fg'],
        'office_sell' => ['name' => 'Office Sell', 'color' => 'bg-secondary text-secondary-fg'],
        'incomplete'    => ['name' => 'Incomplete', 'color' => 'bg-facebook text-facebook-fg'],
        'landing'         => ['name' => 'Landing', 'color' => 'bg-success text-success-fg'],
    ];

    public function getSourceNameAttribute()
    {
        return self::SOURCE[$this->source]['name'] ?? ucfirst(str_replace('_', ' ', $this->source ?? 'N/A'));
    }

    public function getSourceColorAttribute()
    {
        return self::SOURCE[$this->source]['color'] ?? 'bg-secondary text-secondary-fg';
    }




    protected $fillable = [
        'order_date',
        'theme_id',
        'invoice_id',
        'ip_address',
        'device_id',
        'memo_number',
        'customer_activity',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'courier_id',
        'courier_city_id',
        'courier_zone_id',
        'payment_method',
        'shipping_method',
        'shipping_cost',
        'discount',
        'sub_total',
        'total',
        'paid',
        'due',
        'status',
        'customer_note',
        'staff_note',
        'payment_status',
        'source',
        'consignment_id',
        'courier_status',
        'courier_reason_msg',
        'courier_error_msg',
        'tracking_id',
        'is_sent_to_courier',
        'coupon_code',
        'coupon_discount',
        'coupon_applied_on',

        'c_delivery_charge',
        'c_target_amount',
        'c_discount',
        'c_collected_amount',
        'c_paid_amount',
        'cod_charge',
        'total_delivery_fee',
        'is_accounted',
        'is_courier_detailed',
    ];

    protected $casts = [
        'customer_activity' => 'array',
        'courier_error_msg' => 'array',
        'sub_total'       => 'decimal:2',
        'shipping_cost'   => 'decimal:2',
        'discount'        => 'decimal:2',
        'coupon_discount' => 'decimal:2',
        'total'           => 'decimal:2',
        'paid'            => 'decimal:2',
        'due'             => 'decimal:2',
    ];

    public function pathaoCity()
    {
        return $this->hasOne(PathaoCity::class, 'parent_id', 'courier_city_id');
    }

    public function redxArea()
    {
        return $this->hasOne(RedxArea::class, 'parent_id', 'courier_zone_id');
    }

    public function pathaoZone()
    {
        return $this->hasOne(PathaoZone::class, 'parent_id', 'courier_zone_id');
    }

    public function get_products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id')->with('get_product');
    }

    public function get_transactions()
    {
        return $this->hasMany(AccountTransaction::class, 'order_id', 'id');
    }

    public function get_courier()
    {
        return $this->hasOne(Courier::class, 'id', 'courier_id');
    }

    // city and zone
    public function get_city()
    {
        return $this->hasOne(PathaoCity::class, 'id', 'courier_city_id');
    }

    public function get_zone()
    {
        return $this->hasOne(PathaoZone::class, 'id', 'courier_zone_id');
    }

    public function get_assigned()
    {
        return $this->hasOne(OrderAssign::class, 'order_id', 'id');
    }
    // order notes
    // public function get_notes()
    // {
    //     return $this->hasOne(OrderNote::class, 'order_id', 'id')->latestOfMany('id');
    // }
    // staff notes (user_type = 'staff')
    public function get_staff_notes()
    {
        return $this->hasMany(OrderNote::class, 'order_id', 'id')
            ->where('user_type', 'staff')
            ->latest();
    }

    // customer notes (user_type = 'customer')
    public function get_customer_notes()
    {
        return $this->hasMany(OrderNote::class, 'order_id', 'id')
            ->where('user_type', 'customer')
            ->latest();
    }

    // all order notes combined
    public function get_notes()
    {
        return $this->hasMany(OrderNote::class, 'order_id', 'id')->latest();
    }

    // order activity
    public function get_activities()
    {
        return $this->hasMany(OrderActivity::class, 'order_id', 'id')->latest();
    }
    public function activities()
    {
        return $this->hasMany(OrderActivity::class);
    }
}
