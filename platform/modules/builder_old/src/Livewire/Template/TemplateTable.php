<?php

namespace Sokeio\Builder\Livewire\Template;

use Sokeio\Builder\Models\BuilderTemplate;
use Sokeio\Components\Table;
use Sokeio\Components\UI;

class TemplateTable extends Table
{
    protected function  getModel()
    {
        return BuilderTemplate::class;
    }
    protected function getTitle()
    {
        return __('Builder Template');
    }
    protected function getRoute()
    {
        return 'admin.builder-template';
    }
    protected function getButtons()
    {
        return [
            UI::button(__('Create With Builder'))->route($this->getRoute() . '.add')
        ];
    }

    //The record has been deleted successfully.
    protected function getTableActions()
    {
        return [
            UI::buttonEdit(__('Edit With Builder'))->route($this->getRoute() . '.edit', function ($row) {
                return [
                    'dataId' => $row->id
                ];
            }),
            UI::buttonRemove(__('Remove'))->confirm(__('Do you want to delete this record?'), 'Confirm')->wireClick(function ($item) {
                return 'doRemove(' . $item->getDataItem()->id . ')';
            })
        ];
    }
    protected function getQuery()
    {
        return parent::getQuery()->Where(function ($query) {
            $query->orWhere('only_me', 0);
            $query->orWhere(function ($subQuery) {
                $subQuery->where('only_me', true);
                $subQuery->Where('author_id', auth()->user()->id);
            });
        });
    }
    public function doChangeStatus($id, $status)
    {
        $this->getQuery()->where('id', $id)->update(['is_active' => $status]);
    }
    protected function getColumns()
    {
        return [
            UI::text('name')->label(__('Name')),
            UI::text('Category')->label(__('Category')),
            UI::text('topic')->label(__('Topic')),
            UI::text('only_me')->label(__('Only me'))->valueDefault(0)->NoSort(),

        ];
    }
}
