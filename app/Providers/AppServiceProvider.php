<?php

namespace App\Providers;

use App\Actions\TestAction;
use BytePlatform\Facades\Shortcode;
use BytePlatform\Item;
use Illuminate\Support\ServiceProvider;

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
        //
        Shortcode::register([
            Shortcode::Create('test')->View('shortcodes.test')->Title('App Test')->Parameters([
                Item::Add('format')->Title('Format')->ValueDefault('Y-m-d H:i:s'),
            ])->ActionData(TestAction::class),
        ], 'app');
    }
}
