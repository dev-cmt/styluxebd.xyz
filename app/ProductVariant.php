<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{


    protected $fillable = [
        'product_id',
        'sku',
        'variant',
        'purchase_price',
        'regular_price',
        'sale_price',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function items()
    {
        return $this->hasMany(ProductVariantItem::class, 'product_variant_id', 'id');
    }
    public function purchase_items()
    {
        return $this->hasMany(PurchaseItem::class, 'product_id', 'product_id')
            ->where('sku', $this->sku);
    }
}
