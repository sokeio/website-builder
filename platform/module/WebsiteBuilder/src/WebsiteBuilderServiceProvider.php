<?php

namespace Sokeio\Module\WebsiteBuilder;

use Illuminate\Support\ServiceProvider;
use Sokeio\ServicePackage;
use Sokeio\Core\Concerns\WithServiceProvider;

class WebsiteBuilderServiceProvider extends ServiceProvider
{
    use WithServiceProvider;

    public function configurePackage(ServicePackage $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         */
        $package
            ->name('websitebuilder')
            ->hasConfigFile()
            ->hasViews()
            ->hasHelpers()
            ->hasAssets()
            ->hasTranslations()
            ->runsMigrations();
    }
    public function packageRegistered()
    {
        // packageRegistered
    }
    
    public function packageBooted()
    {
        // packageBooted
    }
}
