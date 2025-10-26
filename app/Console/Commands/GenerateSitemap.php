<?php

namespace App\Console\Commands;

use Spatie\Sitemap\Sitemap;

use Illuminate\Console\Command;
use App\Models\Project;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/about'))
            ->add(Url::create('/contact'))
            ->add(Url::create('/projects'))
            ->add(Url::create('/blog'));
            Project::all()->each(function ($project) use ($sitemap) {
                $sitemap->add(Url::create("/projects/{$project->slug}"));
            });
        // Save the sitemap to the public folder
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ Sitemap generated successfully!');
    }
}
