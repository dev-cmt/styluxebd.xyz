<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarrybeeCity extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
    ];
}
