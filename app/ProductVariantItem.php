<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantItem extends Model
{


    protected $fillable = [
        'product_variant_id',
        'attribute_id',
        'attribute_item_id',
        'name',
        'image',
    ];

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'id', 'attribute_id');
    }

    public function attribute_item()
    {
        return $this->hasOne(AttributeItem::class, 'id', 'attribute_item_id');
    }

    // image
    public function item_image()
    {
        return $this->hasOne(Media::class, 'id', 'image');
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
        // নোট: Foreign Key যদি 'product_variant_id' না হয়ে 'variant_id' হয়, তবে আপনার ডাটাবেজ কলাম অনুযায়ী সেটি বসান।
    }
}
