<?php

namespace Sokeio\Builder\Livewire\Plugin;

use Sokeio\Builder\Models\BuilderPlugin;
use Sokeio\Components\Form;
use Sokeio\Components\UI;

class PluginForm extends Form
{
    protected function  getModel()
    {
        return BuilderPlugin::class;
    }
    protected function getTitle()
    {
        return __('Builder Plugin');
    }
    protected function formUI()
    {
        return UI::prex('data', [
            UI::text('name')->label(__('Name'))->required(),
            UI::textarea('js')->label(__('JS'))->valueDefault('[]')->required()->regexArray(),
            UI::textarea('css')->label(__('CSS'))->valueDefault('[]')->required()->regexArray(),
            UI::textarea('options')->label(__('Options'))->valueDefault('[]')->required()->regexArray(),
            UI::checkBox('is_active')->label(__('Active'))->title(__('Active'))->valueDefault(1)->required()
        ])->className('p-2');
    }
}
