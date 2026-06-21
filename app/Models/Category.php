<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'main_category_id',
        'seo_description',
        'seo_keywords',
        'og_image',
        'order',
    ];

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
