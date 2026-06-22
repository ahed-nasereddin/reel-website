<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon' => $this->icon,
            'url' => url('/equipment/' . ($this->mainCategory->slug ?? 'equipment') . '/' . $this->slug),
            'main_category' => new MainCategoryResource($this->whenLoaded('mainCategory')),
            'sub_categories' => SubCategoryResource::collection($this->whenLoaded('subCategories')),
        ];
    }
}
