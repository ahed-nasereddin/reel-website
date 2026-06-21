<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sub_description',
        'description',
        'price',
        'unit',
        'brand_id',
        'main_category_id',
        'category_id',
        'sub_category_id',
        'main_image',
        'images',
        'specs',
        'available',
        'seo_description',
        'seo_keywords',
        'og_image',
    ];

    protected $casts = [
        'images' => 'array',
        'specs' => 'array',
        'available' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
