<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{

    protected $guarded = [];

    public function get_image()
    {
        return $this->hasOne(Media::class, 'id', 'image')->select('id', 'file_url');
    }
}
