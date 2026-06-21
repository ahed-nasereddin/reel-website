<?php

namespace App\Services;

use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\MainCategoryResource;
use App\Http\Resources\SubCategoryResource;
use App\Repositories\CatalogRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class CatalogService
{
    public function __construct(
        protected CatalogRepository $repository,
        protected SeoService $seoService,
    ) {
    }

    public function navigation(): array
    {
        $navigation = $this->repository->getNavigation();

        return MainCategoryResource::collection($navigation)->resolve();
    }

    public function mainCategories(): array
    {
        return MainCategoryResource::collection($this->repository->getMainCategories())->resolve();
    }

    public function categories(array $filters = []): array
    {
        return CategoryResource::collection($this->repository->getCategories($filters))->resolve();
    }

    public function subCategories(array $filters = []): array
    {
        return SubCategoryResource::collection($this->repository->getSubCategories($filters))->resolve();
    }

    public function brands(): array
    {
        return BrandResource::collection($this->repository->getBrands())->resolve();
    }

    public function items(array $filters = []): array
    {
        $items = $this->repository->getItems($filters);

        return [
            'data' => ItemResource::collection($items)->resolve(),
            'meta' => $this->paginationMeta($items),
            'seo' => $this->seoService->generateForStaticPage('items', [
                'filters' => $filters,
            ]),
        ];
    }

    public function itemDetails(string $slug): array
    {
        $item = $this->repository->getItemBySlug($slug);

        if (! $item) {
            return [];
        }

        return [
            'data' => (new ItemResource($item))->resolve(),
            'seo' => $this->seoService->generateForItem($item),
        ];
    }

    public function relatedItems(int $itemId): array
    {
        return ItemResource::collection($this->repository->getRelatedItems($itemId))->resolve();
    }

    private function paginationMeta(LengthAwarePaginator $items): array
    {
        return [
            'current_page' => $items->currentPage(),
            'last_page' => $items->lastPage(),
            'per_page' => $items->perPage(),
            'total' => $items->total(),
        ];
    }
}
