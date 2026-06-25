<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (!Schema::hasTable('site_settings')) {
                return;
            }

            $siteSettings = SiteSetting::firstOrCreate(
                ['id' => 1],
                [
                    'site_name' => 'Sozo Habitat',
                    'email' => 'contact@sozohabitat.com',
                    'phone_1' => '0787463032',
                    'phone_2' => '0787587996',
                    'whatsapp' => '2250787463032',
                    'address' => 'Côte d\'Ivoire',
                ]
            );

            $view->with('siteSettings', $siteSettings);
        });
    }
}