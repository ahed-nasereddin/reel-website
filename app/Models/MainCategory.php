<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    protected $table = 'main_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'seo_description',
        'seo_keywords',
        'og_image',
        'image',
        'order',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
