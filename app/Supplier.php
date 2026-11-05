<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'balance',
        'type',
    ];
    //supplier has many transactions
    public function transactions()
    {
        return $this->hasMany(SupplierTransaction::class);
    }
}
