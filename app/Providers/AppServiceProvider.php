<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Document;
use App\Observers\CategoryObserver;
use App\Observers\DocumentObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Document::observe(DocumentObserver::class);
        Category::observe(CategoryObserver::class);
    }
}