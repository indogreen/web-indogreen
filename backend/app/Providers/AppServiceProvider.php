<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Office;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\SiteSetting;
use App\Models\Solution;
use App\Observers\ContentVersionObserver;
use App\Policies\RolePolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Role::class, RolePolicy::class);

        // Rate limiter untuk formulir inquiry: 5 request per menit per IP
        RateLimiter::for('inquiries', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip() ?: 'anonymous');
        });

        // Bumping cache version saat data konten berubah
        $cacheableModels = [
            Product::class,
            Category::class,
            Solution::class,
            HeroSlide::class,
            Page::class,
            Office::class,
            SiteSetting::class,
            ProductSpecification::class,
        ];

        foreach ($cacheableModels as $modelClass) {
            $modelClass::observe(ContentVersionObserver::class);
        }
    }
}
