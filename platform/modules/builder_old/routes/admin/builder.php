<?php

use Illuminate\Support\Facades\Route;
use Sokeio\Builder\Livewire\Plugin\PluginForm;
use Sokeio\Builder\Livewire\Plugin\PluginTable;
use Sokeio\Builder\Livewire\Template\TemplateForm;
use Sokeio\Builder\Livewire\Template\TemplateTable;
use Sokeio\Builder\Livewire\TemplateManager;

Route::group([
    'as' => 'admin.',
], function () {
    Route::post('template-manager', TemplateManager::class)->name('builder.template-manager');
    routeCrud('builder-plugin', PluginTable::class, PluginForm::class);
    routeCrud('builder-template', TemplateTable::class, TemplateForm::class, true);
});
