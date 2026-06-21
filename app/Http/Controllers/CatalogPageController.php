<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\CatalogService;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CatalogPageController extends Controller
{
    public function __construct(
        protected CatalogService $catalogService,
        protected SeoService $seoService
    ) {
    }

    public function items(Request $request)
    {
        $filters = $request->only([
            'main_category_slug',
            'category_slug',
            'sub_category_slug',
            'brand_slug',
            'q',
            'page',
            'per_page',
        ]);

        $itemsData = $this->catalogService->items($filters);

        return Inertia::render('catalog/ItemsIndex', [
            'items' => $itemsData['data'],
            'meta' => $itemsData['meta'],
            'seo' => $itemsData['seo'],
            'categories' => $this->catalogService->categories(),
            'brands' => $this->catalogService->brands(),
            'selectedFilters' => $filters,
        ]);
    }

    public function itemDetails(string $slug)
    {
        $itemData = $this->catalogService->itemDetails($slug);

        if (empty($itemData['data'])) {
            abort(404);
        }

        return Inertia::render('catalog/ItemDetails', [
            'item' => $itemData['data'],
            'seo' => $itemData['seo'],
            'relatedItems' => $this->catalogService->relatedItems($itemData['data']['id']),
            'whatsapp_number' => config('services.whatsapp.number') ?? env('WHATSAPP_NUMBER') ?? null,
        ]);
    }

    public function categoryPage(Request $request,?string $category = null, ?string $subCategory = null)
    {
        
        $filters = $request->only([
            'brand_slug',
            'q',
            'page',
            'per_page',
        ]);

        if ($category) {
            $filters['category_slug'] = $category;
        }

        if ($subCategory) {
            $filters['sub_category_slug'] = $subCategory;
        }

        $itemsData = $this->catalogService->items($filters);

        $categoryModel = $category
            ? Category::with(['mainCategory', 'subCategories'])->where('slug', $category)->first()
            : null;

        $subCategoryModel = $subCategory
            ? SubCategory::with('category.mainCategory')->where('slug', $subCategory)->first()
            : null;

        $seo = $subCategoryModel
            ? $this->seoService->generateForSubCategory($subCategoryModel)
            : ($categoryModel ? $this->seoService->generateForCategory($categoryModel) : $itemsData['seo']);

        return Inertia::render('catalog/CategoryPage', [
            'items' => $itemsData['data'],
            'meta' => $itemsData['meta'],
            'seo' => $seo,
            'categories' => $this->catalogService->categories(),
            'brands' => $this->catalogService->brands(),
            'selectedFilters' => $filters,
            'category' => $categoryModel ? (new CategoryResource($categoryModel))->resolve() : null,
            'subCategory' => $subCategoryModel ? (new SubCategoryResource($subCategoryModel))->resolve() : null,
        ]);
    }
}
