<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{


    protected $fillable = [
        'purchase_id',
        'product_id',
        'sku',
        'ordered_quantity',
        'received_quantity',
        'stock_quantity',
        'purchase_cost',
        'total',
        'sale_priority',
    ];

    public function get_purchase()
    {
        return $this->hasOne(Purchase::class, 'id', 'purchase_id');
    }

    public function get_product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
