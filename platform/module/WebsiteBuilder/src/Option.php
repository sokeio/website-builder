<?php

namespace Sokeio\Module\WebsiteBuilder;

use Sokeio\WithOption;

class Option
{
    use WithOption;
      // Only Theme Site
    public static function setupOption()
    {
        // Run when activating
    }
    public static function activate()
    {
        // Run when activating
    }

    public static function activated()
    {
        // Run when is activated
    }

    public static function deactivate()
    {
        // Run when deactivating
    }

    public static function deactivated()
    {
        // Run when is deactivated
    }

    public static function remove()
    {
        // Run when remove
    }

    public static function removed()
    {
        // Run when removed
    }
}
