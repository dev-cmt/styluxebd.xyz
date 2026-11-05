<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseBill extends Model
{
    protected $fillable = [
        'supplier_id',
        'category_id',
        'title',
        'amount',
        'bill_date',
        'status',
        'note',
    ];


    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id', 'id');
    }
}
