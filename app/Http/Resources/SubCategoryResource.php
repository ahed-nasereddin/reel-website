<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'url' => url('/equipment/' . ($this->category->mainCategory->slug ?? 'equipment') . '/' . $this->category->slug . '/' . $this->slug),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
