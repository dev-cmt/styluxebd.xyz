<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintSetting extends Model
{

    protected $fillable = [
        'single_print',
        'bulk_print',
    ];
}
