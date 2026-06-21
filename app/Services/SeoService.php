<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Item;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Support\Arr;

class SeoService
{
    public function generateForMainCategory(MainCategory $mainCategory): array
    {
        $title = sprintf('%s Rental in UAE | ReelQuip Films', $mainCategory->name);
        $description = $mainCategory->seo_description ?? sprintf('Explore premium %s rentals for film, TV, and commercial production in the UAE.', strtolower($mainCategory->name));
        $keywords = $mainCategory->seo_keywords ?? implode(', ', [strtolower($mainCategory->name), 'equipment rental', 'film production rental', 'UAE']);
        $canonical = url('/equipment/' . $mainCategory->slug);
        $image = $mainCategory->og_image ? asset('storage/' . $mainCategory->og_image) : asset('default-project.jpg');

        return $this->buildSeoPayload($title, $description, $keywords, $canonical, $image, 'website');
    }

    public function generateForCategory(Category $category): array
    {
        $title = sprintf('%s Rental & Crew Gear | ReelQuip Films', $category->name);
        $description = $category->seo_description ?? sprintf('Rent %s from our UAE film production inventory. Fast delivery and premium support.', strtolower($category->name));
        $keywords = $category->seo_keywords ?? implode(', ', [strtolower($category->name), 'film equipment rental', 'shooting gear UAE']);
        $canonical = url('/equipment/' . ($category->mainCategory->slug ?? 'equipment') . '/' . $category->slug);
        $image = $category->og_image ? asset('storage/' . $category->og_image) : asset('default-project.jpg');

        return $this->buildSeoPayload($title, $description, $keywords, $canonical, $image, 'website');
    }

    public function generateForSubCategory(SubCategory $subCategory): array
    {
        $title = sprintf('%s Rental | ReelQuip Films', $subCategory->name);
        $description = $subCategory->seo_description ?? sprintf('Discover %s rentals for professional UAE production. High-quality gear and expert service.', strtolower($subCategory->name));
        $keywords = $subCategory->seo_keywords ?? implode(', ', [strtolower($subCategory->name), 'rental', 'production gear']);
        $canonical = url('/equipment/' . ($subCategory->category->mainCategory->slug ?? 'equipment') . '/' . $subCategory->category->slug . '/' . $subCategory->slug);
        $image = $subCategory->og_image ? asset('storage/' . $subCategory->og_image) : asset('default-project.jpg');

        return $this->buildSeoPayload($title, $description, $keywords, $canonical, $image, 'website');
    }

    public function generateForItem(Item $item): array
    {
        $title = sprintf('%s %s Rental | %s', $item->brand?->name ?? '', $item->name, 'ReelQuip Films');
        $description = $item->seo_description ?: sprintf('Rent %s %s for film production in UAE. Competitive pricing, flexible rental terms, and fast service.', $item->brand?->name ?? '', strtolower($item->name));
        $keywords = $item->seo_keywords ?? implode(', ', array_filter([
            strtolower($item->name),
            strtolower($item->brand?->name ?? ''),
            'camera rental',
            'lighting rental',
            'production gear UAE',
        ]));
        $canonical = url('/items/' . $item->slug);
        $image = $item->main_image ? asset('storage/' . $item->main_image) : asset('default-project.jpg');

        $productSchema = [
            '@type' => 'Product',
            'name' => $item->name,
            'description' => $description,
            'image' => [$image],
            'brand' => [
                '@type' => 'Brand',
                'name' => $item->brand?->name ?? 'ReelQuip Films',
            ],
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'AED',
                'price' => $item->price_daily ?: $item->price ?: '0',
                'availability' => 'https://schema.org/InStock',
                'url' => $canonical,
                'itemCondition' => 'https://schema.org/UsedCondition',
            ],
        ];

        $jsonLd = $this->buildJsonLd(
            [
                '@context' => 'https://schema.org',
                '@graph' => [
                    $productSchema,
                    [
                        '@type' => 'BreadcrumbList',
                        'itemListElement' => [
                            ['@type' => 'ListItem', 'position' => 1, 'item' => ['@id' => url('/'), 'name' => 'Home' ]],
                            ['@type' => 'ListItem', 'position' => 2, 'item' => ['@id' => url('/items'), 'name' => 'Items' ]],
                            ['@type' => 'ListItem', 'position' => 3, 'item' => ['@id' => $canonical, 'name' => $item->name ]],
                        ],
                    ],
                ],
            ]
        );

        return $this->buildSeoPayload($title, $description, $keywords, $canonical, $image, 'product', $jsonLd);
    }

    public function generateForStaticPage(string $page, array $data = []): array
    {
        $defaults = [
            'home' => [
                'title' => 'Film Equipment Rental UAE | ReelQuip Films',
                'description' => 'Premium film production equipment rental across camera, lighting, grip and crew services in the UAE.',
                'keywords' => 'film equipment rental, production gear, camera rental, lighting rental, UAE',
                'canonical' => url('/'),
                'image' => asset('default-project.jpg'),
                'type' => 'website',
            ],
            'items' => [
                'title' => 'Camera Equipment Rental in UAE | Film Production Gear',
                'description' => 'Browse cinema-grade production items for rental in the UAE. Filter by brand, category, and availability.',
                'keywords' => 'camera rental, lighting rental, film equipment rental, UAE production gear',
                'canonical' => url('/items'),
                'image' => asset('default-project.jpg'),
                'type' => 'website',
            ],
        ];

        $pageMeta = $defaults[$page] ?? $defaults['home'];

        if (!empty($data['filters'])) {
            $filters = $data['filters'];
            $pageMeta['description'] = sprintf('Filtered gear for %s rentals in UAE. %s',
                implode(', ', array_filter([$filters['brand_slug'] ?? null, $filters['category_slug'] ?? null, $filters['sub_category_slug'] ?? null])),
                $pageMeta['description']
            );
            $pageMeta['canonical'] = url('/items');
        }

        return $this->buildSeoPayload(
            $data['title'] ?? $pageMeta['title'], 
            $data['description'] ?? $pageMeta['description'], 
            $data['keywords'] ?? $pageMeta['keywords'], 
            $data['canonical'] ?? $pageMeta['canonical'], 
            $data['image'] ?? $pageMeta['image'], 
            $data['type'] ?? $pageMeta['type']
        );
    }

    private function buildSeoPayload(string $title, string $description, string $keywords, string $canonical, string $image, string $type = 'website', array $jsonLd = []): array
    {
        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'canonical' => $canonical,
            'og' => [
                'title' => $title,
                'description' => $description,
                'image' => $image,
                'url' => $canonical,
                'type' => $type,
            ],
            'twitter' => [
                'card' => 'summary_large_image',
                'title' => $title,
                'description' => $description,
                'image' => $image,
                'url' => $canonical,
            ],
            'jsonLd' => $jsonLd ?: $this->buildJsonLd([
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'url' => $canonical,
                'name' => $title,
                'description' => $description,
            ]),
        ];
    }

    private function buildJsonLd(array $data): array
    {
        return $data;
    }
}
