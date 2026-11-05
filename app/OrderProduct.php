<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'purchase_price',
        'price',
        'attributes',
        'product_sku',
        'discount',
    ];
    protected $casts = [
        'price'          => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'discount'       => 'decimal:2',
    ];

    public function get_product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->with('get_thumb', 'get_feature_image');
    }
    // order combo items
    public function orderComboItems()
    {
        return $this->hasMany(OrderComboItem::class, 'order_product_id', 'id')->with('product');
    }

    // order
    public function get_order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
    public function getFormattedAttributesListAttribute()
    {
        // 1. $this->getAttribute('attributes') ব্যবহার করে ডাটাবেজ কলামের স্ট্রিং ভ্যালু নেওয়া
        $rawAttributes = $this->getAttribute('attributes');

        if (empty($rawAttributes) || is_array($rawAttributes) || !$this->get_product) {
            return collect();
        }

        $ids = explode('-', $rawAttributes);

        // 2. Variants ও Attributes ফেচ করা
        if (!$this->get_product->get_variants) {
            return collect();
        }

        return $this->get_product
            ->get_variants()
            ->with('items')
            ->get()
            ->pluck('items')
            ->flatten()
            ->whereIn('attribute_item_id', $ids)
            ->unique('attribute_item_id');
    }
}
