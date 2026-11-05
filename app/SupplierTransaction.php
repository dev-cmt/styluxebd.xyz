<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierTransaction extends Model
{
    // protected $table = 'supplier_transactions';
    protected $fillable = [
        'supplier_id',
        'type',
        'amount',
        'previous_balance',
        'new_balance',
        'notes',
    ];
}
