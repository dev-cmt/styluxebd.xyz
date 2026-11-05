<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrybeeZone extends Model
{
    protected $fillable = [
        'parent_id',
        'city_id',
        'name',
    ];
}
