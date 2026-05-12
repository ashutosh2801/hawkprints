<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SitemapController;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml file in public directory';

    public function handle(SitemapController $controller)
    {
        $controller->generate();
        $this->info('Sitemap generated successfully at public/sitemap.xml');
    }
}
