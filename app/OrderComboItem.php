<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderComboItem extends Model
{
    protected $fillable = [
        'order_product_id',
        'product_id',
        'sku',
        'qty',
        'variant_id'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->with('get_thumb', 'get_feature_image');
    }

    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id', 'id');
    }

    public function variant()
    {
        return $this->hasOne(ProductVariant::class, 'id', 'variant_id')->with('items');
    }

    // variant name accessor
    public function getVariantNameAttribute()
    {
        if ($this->variant) {
            return $this->variant->items->pluck('name')->implode(', ');
        }
    }
}
