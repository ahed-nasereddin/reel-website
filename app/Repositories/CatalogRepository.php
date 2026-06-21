<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Collection;

class CatalogRepository
{
    public function getNavigation(): Collection
    {
        return MainCategory::with(['categories.subCategories'])
            ->orderBy('order', 'asc')
            ->get();
    }

    public function getMainCategories(): Collection
    {
        return MainCategory::withCount('categories')
            ->orderBy('order', 'asc')
            ->get();
    }

    public function getCategories(array $filters = []): Collection
    {
        $query = Category::with('subCategories')->orderBy('order', 'asc');

        if (!empty($filters['main_category_slug'])) {
            $query->whereHas('mainCategory', fn($q) => $q->where('slug', $filters['main_category_slug']));
        }

        return $query->get();
    }

    public function getSubCategories(array $filters = []): Collection
    {
        $query = SubCategory::orderBy('order', 'asc');

        if (!empty($filters['category_slug'])) {
            $query->whereHas('category', fn($q) => $q->where('slug', $filters['category_slug']));
        }

        return $query->get();
    }

    public function getBrands(): Collection
    {
        return Brand::orderBy('name', 'asc')->get();
    }

    public function getItems(array $filters = [])
    {
        $query = Item::with(['brand', 'subCategory']);

        

        if (!empty($filters['main_category_slug'])) {
            $mainSlug = $filters['main_category_slug'];
            $query->whereHas('subCategory', function ($q) use ($mainSlug) {
                $q->whereHas('category', function ($q2) use ($mainSlug) {
                    $q2->whereHas('mainCategory', fn($q3) => $q3->where('slug', $mainSlug));
                });
            });
        }

        if (!empty($filters['category_slug'])) {
            $catSlug = $filters['category_slug'];
            $query->whereHas('subCategory', function ($q) use ($catSlug) {
                $q->whereHas('category', fn($q2) => $q2->where('slug', $catSlug));
            });
        }

        if (!empty($filters['sub_category_slug'])) {
            $query->whereHas('subCategory', fn($q) => $q->where('slug', $filters['sub_category_slug']));
        }

        if (!empty($filters['brand_slug'])) {
            $query->whereHas('brand', fn($q) => $q->where('slug', $filters['brand_slug']));
        }

        if (!empty($filters['q'])) {
            $query->where(function ($q) use ($filters) {
                $search = '%' . trim($filters['q']) . '%';
                $q->where('name', 'like', $search)
                    ->orWhere('short_description', 'like', $search)
                    ->orWhere('description', 'like', $search);
            });
        }

        return $query->paginate($filters['per_page'] ?? 12);
    }

    public function getItemBySlug(string $slug): ?Item
    {
        return Item::with(['brand', 'subCategory', 'subCategory.category'])
            ->where('slug', $slug)
            ->first();
    }

    public function getRelatedItems(int $id)
    {
        $item = Item::find($id);

        if (! $item) {
            return Item::query()->take(4)->get();
        }

        return Item::with(['brand',  'subCategory'])
            ->where('id', '!=', $item->id)
            ->where(function ($query) use ($item) {
                
                if ($item->sub_category_id) {
                    $query->orWhere('sub_category_id', $item->sub_category_id);
                }
                if ($item->brand_id) {
                    $query->orWhere('brand_id', $item->brand_id);
                }
            })
            ->take(6)
            ->get();
    }
}
