<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        $images = $this->images;

        if (is_string($images)) {
            $decoded = json_decode($images, true);
            $images = is_array($decoded) ? $decoded : array_filter(array_map('trim', explode(',', $images)));
        }

        return [
            'id' => $this->id,
            'title' => $this->name,
            'slug' => $this->slug,
            'sub_description' => $this->summary,
            'description' => $this->description,
            'price' => $this->price,
            'unit' => $this->unit,
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'sub_category' => new SubCategoryResource($this->whenLoaded('subCategory')),
            'category' => new CategoryResource($this->whenLoaded('subCategory.category')),
            'main_category' => new MainCategoryResource($this->whenLoaded('mainCategory')),
            'images' => $images ? array_map(fn($image) => asset('storage/' . $image), (array) $images) : [],
            'main_image' => $this->main_image ? asset('storage/' . $this->main_image) : null,
            'specs' => $this->specs,
            'available' => (bool) $this->available,
            'url' => url('/items/' . $this->slug),
        ];
    }
}
