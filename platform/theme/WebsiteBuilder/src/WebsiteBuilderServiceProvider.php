<?php

namespace Sokeio\Theme\WebsiteBuilder;

use Illuminate\Support\ServiceProvider;
use Sokeio\ServicePackage;
use Sokeio\Core\Concerns\WithServiceProvider;
use Sokeio\Platform;
use Sokeio\Theme;

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
        if (!Platform::isUrlAdmin()) {
            Theme::linkJs(
                url('platform/module/sokeio/tabler/js/tabler.min.js'),
                'https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js'
            );
            Theme::linkCss(
                url('platform/module/sokeio/tabler/css/tabler.min.css'),
                'https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css'
            );
            Theme::linkCss(
                url('platform/module/sokeio/tabler-icons/tabler-icons.min.css'),
                'https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.14.0/tabler-icons.min.css'
            );
            Theme::linkCss(
                url('platform/module/sokeio/bootstrap-icons/bootstrap-icons.min.css')
            );
        }
    }
}
