<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{


    protected $fillable = [
        'supplier_id',
        'account_id',
        'memo_no',
        'remarks',
        'subtotal',
        'discount',
        'tax',
        'shipping_cost',
        'total',
        'paid_amount',
        'previous_due',
        'due_amount',
        'purchase_date',
        'note',
        'created_by',
        'status',
    ];

    public function get_supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function get_purchase_items()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id', 'id')->with('get_product');
    }
}
