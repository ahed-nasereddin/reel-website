<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    protected $table="projects";
    protected $casts = [
    'videos' => 'array',
];
    protected static function booted()
    {
        static::creating(function ($project) {
            if (empty($project->slug)) {
                $slug = Str::slug($project->name);
                $originalSlug = $slug;
                $count = 1;

                // Check for duplicates and add suffix
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }

                $project->slug = $slug;
            }
        });}
}
