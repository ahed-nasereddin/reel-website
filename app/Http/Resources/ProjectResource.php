<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'id'             => $this->id,
            'name'          => $this->name,
            'slug'           => $this->slug,
            'main_image'     => $this->main_image 
                                ? asset('storage/' . $this->main_image) 
                                : null,
            'images'         => $this->images 
                                ? collect(json_decode($this->images))
                                    ->map(fn($img) => asset('storage/' . $img))
                                : [],
            'videos'         => $this->videos 
                                ? collect(json_decode($this->videos))
                                    ->map(fn($video) => asset('storage/' . $video))
                                : [],
            'client' => $this->client,
            'description'    => $this->description,
            'services'       => $this->services 
                                ? array_values((array) json_decode($this->services)) 
                                : [],
            'created_at'     => $this->created_at->toDateTimeString(),
        ];

    }

    public function minimal(): array
    {
        return [
            'id'             => $this->id,
            'name'          => $this->name,
             'slug'           => $this->slug,
            'description'          => $this->description,
            'main_image'     => $this->main_image 
                                 ? asset('storage/' . $this->main_image) 
                                 : null,
            'client' => $this->client,
        ];
    }
}
