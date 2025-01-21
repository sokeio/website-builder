<?php

namespace Sokeio\Builder\Livewire\Plugin;

use Sokeio\Builder\Models\BuilderPlugin;
use Sokeio\Components\Table;
use Sokeio\Components\UI;

class PluginTable extends Table
{
    protected function  getModel()
    {
        return BuilderPlugin::class;
    }
    protected function getTitle()
    {
        return __('Builder Plugin');
    }
    protected function getRoute()
    {
        return 'admin.builder-plugin';
    }
    public function doChangeStatus($id, $status)
    {
        $this->getQuery()->where('id', $id)->update(['is_active' => $status]);
    }
    protected function getColumns()
    {
        return [
            UI::text('name')->label(__('Name')),
            UI::textarea('js')->label(__('JS'))->valueDefault('[]'),
            UI::textarea('css')->label(__('CSS'))->valueDefault('[]'),
            UI::textarea('options')->label(__('Options'))->valueDefault('[]'),
            UI::button('is_active')->label(__('Active'))->title(__('Active'))->NoSort()->wireClick(function ($item) {
                if ($item->getDataItem()->is_active === true) {
                    $item->title(__('Active'));
                    $item->primary();
                } else {
                    $item->title(__('Block'));
                    $item->warning();
                }
                return 'doChangeStatus(' . $item->getDataItem()->id . ',' . ($item->getDataItem()->status === true ? 0 : 1) . ')';
            })
        ];
    }
}
