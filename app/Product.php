<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{


    protected $fillable = [
        'sku',
        'thumb',
        'image',
        'gallery_images',
        'size_chart',
        'name',
        'slug',
        'stock',
        'description',
        'purchase_price',
        'regular_price',
        'sale_price',
        'status',
        'has_variant',
        'free_shipping',
        'is_combo',
        'is_package',
        'package_qty',
        'extra_fields',
        'theme_id',
        'related_products',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
    ];

    protected $casts = [
        'extra_fields' => 'array',
        'related_products' => 'array',
        'free_shipping' => 'boolean',
    ];

    public function get_purchase_items()
    {
        return $this->hasMany(PurchaseItem::class, 'product_id', 'id');
    }
    public function getTotalStockAttribute()
    {
        // ১. যদি প্রোডাক্টের ভ্যারিয়েন্ট থাকে, তবে সব ভ্যারিয়েন্টের স্টকের যোগফল দেখাবে
        if ($this->has_variant == 1 && $this->relationLoaded('get_variants')) {
            return $this->get_variants->sum('stock');
        }

        // ২. যদি পারচেজ টেবিল বা অ্যাডভান্স স্টক (purchase_items) থেকে স্টক থাকে
        if ($this->relationLoaded('get_purchase_items') && $this->get_purchase_items->count() > 0) {
            $purchaseStock = $this->get_purchase_items->sum('stock_quantity');
            if ($purchaseStock > 0) {
                return $purchaseStock;
            }
        }

        // ৩. ডিফল্টভাবে প্রোডাক্ট টেবিলের নিজস্ব স্টক রিটার্ন করবে
        return $this->stock ?? 0;
    }

    public function get_variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id')->with('items');
    }

    public function get_variant_items()
    {
        return $this->hasManyThrough(ProductVariantItem::class, ProductVariant::class);
    }
    // App\Models\Product.php

    public function get_variant_item_ids()
    {
        $items = $this->get_variant_items()
            ->select('attribute_id', 'attribute_item_id')
            ->get()
            ->groupBy('attribute_id');

        // output structure বানানো হচ্ছে
        $result = [];
        foreach ($items as $attribute_id => $attribute_items) {
            $result[$attribute_id] = $attribute_items->pluck('attribute_item_id')->unique()->values()->toArray();
        }

        return $result;
    }

    public function get_attribute_with_items()
    {
        $result = [];
        $items = $this->get_variant_items()
            ->with(['attribute', 'attribute_item', 'item_image']) // এখানে item_image include করা দরকার
            ->get()
            ->groupBy('attribute_id');

        foreach ($items as $attribute_id => $group) {
            $result[] = [
                'attribute' => $group->first()->attribute,
                'items' => $group->unique('attribute_item_id')->values(),
            ];
        }

        return collect($result);
    }

    public function get_category()
    {
        return $this->hasOne(CategoryProduct::class, 'product_id', 'id');
    }
    public function get_single_category()
    {
        return $this->hasOne(CategoryProduct::class, 'product_id', 'id')->with('get_category');
    }

    public function get_categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }

    public function get_category_products()
    {
        return $this->hasMany(CategoryProduct::class, 'product_id', 'id')->with('get_category', 'get_product');
    }

    public function get_thumb()
    {
        return $this->hasOne(Media::class, 'id', 'thumb')->select('id', 'file_url');
    }

    public function get_feature_image()
    {
        return $this->hasOne(Media::class, 'id', 'image')->select('id', 'file_url');
    }

    public function get_gallery_images()
    {
        return $this->hasMany(Media::class, 'id', 'gallery_images')->select('id', 'file_url');
    }

    public function gallery_images()
    {
        if (! $this->gallery_images) {
            return collect();
        }

        $ids = explode(',', $this->gallery_images);

        return Media::whereIn('id', $ids)->get();
    }

    public function getImagesAttribute()
    {
        if ($this->gallery_images) {
            $photos = explode(',', $this->gallery_images);
        } else {
            $photos = [];
        }
        $p = [];
        foreach ($photos as $photo) {
            $p[] = Media::find($photo)->file_url;
        }

        return $p;
    }

    //size chart
    public function get_size_chart()
    {
        return $this->hasOne(Media::class, 'id', 'size_chart')->select('id', 'file_url');
    }

    public function get_reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id')->latest();
    }

    // get order products
    public function get_order_products()
    {
        return $this->hasMany(OrderProduct::class, 'product_id', 'id')->with('get_order');
    }

    public function get_discount_percent()
    {
        $discount = 0;
        if ($this->sale_price > 0) {
            $discount = (($this->price - $this->sale_price) * 100) / $this->price;
        }

        return round($discount);
    }

    public function comboItems()
    {
        return $this->hasMany(ComboProduct::class, 'combo_product_id');
    }

    public function getHoverImageIdAttribute()
    {
        return $this->extra_fields['hover_image'] ?? null;
    }

    public function hoverImage()
    {
        return $this->belongsTo(\App\Media::class, 'hover_image_id');
    }

    // flash deal
    public function getFlashDeals()
    {
        return $this->belongsToMany(FlashDeal::class, 'flash_deal_products', 'product_id', 'flash_deal_id')->with('products');
    }

    protected static function booted()
    {
        // ১. ক্যশে ক্লিয়ার
        static::saved(function ($product) {
            cache()->forget('theme_' . $product->theme_id . '_new_arrivals');
            cache()->forget('theme_' . $product->theme_id . '_hot_sale');
            cache()->forget('theme_' . $product->theme_id . '_trending');
            cache()->forget('theme_' . $product->theme_id . '_featured');
        });

        // ২. প্রোডাক্ট ডিলিট হওয়ার সময় রিলেটেড সব ডাটা ক্লিয়ার করা
        static::deleting(function ($product) {
            // Categories relation link delete
            $product->get_category_products()->delete();

            // Variants & Variant Items delete
            $product->get_variants()->each(function ($variant) {
                $variant->items()->delete(); // Variant items delete
                $variant->delete(); // Variant delete
            });

            // Reviews delete
            $product->get_reviews()->delete();

            // Combo Product items delete
            $product->comboItems()->delete();

            // Flash Deal relations delete (Pivot Table)
            DB::table('flash_deal_products')->where('product_id', $product->id)->delete();
        });
    }
}
