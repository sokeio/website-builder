<?php

namespace Sokeio\Builder\Livewire\Template;

use Sokeio\Builder\FormBuilder;
use Sokeio\Builder\Models\BuilderTemplate;
use Sokeio\Components\UI;

class TemplateForm extends FormBuilder
{
    protected function  getModel()
    {
        return BuilderTemplate::class;
    }
    protected function getTitle()
    {
        return __('Builder Template');
    }
    protected function getPageList()
    {
        return route('admin.builder-template');
    }
    ///'name', 'js', 'css', 'options', 'is_active'
    protected function formUI()
    {
        return UI::prex('data', [
            UI::hidden('author_id')->valueDefault(function () {
                return auth()->user()->id;
            }),
            UI::hidden('content')->valueDefault(''),
            UI::text('name')->label(__('Name'))->required(),
            UI::image('thumbnail')->label(__('Thumbnail'))->valueDefault(''),
            UI::text('category')->label(__('Category'))->valueDefault('common')->required(),
            UI::text('topic')->label(__('Topic'))->required(),
            UI::textarea('description')->label(__('Description'))->valueDefault(''),
            UI::checkBox('only_me')->label(__('Only me'))->title(__('Only me use this template'))->valueDefault(0),
            UI::text('email')->label(__('Email')),
            UI::select('status')->label(__('Status'))->dataSource(function () {
                return [
                    [
                        'id' => 'draft',
                        'name' => __('Draft')
                    ],
                    [
                        'id' => 'published',
                        'name' => __('Published')
                    ]
                ];
            })->valueDefault('published'),
        ]);
    }
}
