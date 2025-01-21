<?php

namespace Sokeio\Builder;

use Livewire\Attributes\Url;
use Sokeio\Builder\Models\BuilderPlugin;
use Sokeio\Facades\Shortcode;
use Sokeio\Components\Form;
use Sokeio\Facades\Assets;
use Sokeio\Facades\Theme;

class FormBuilder extends Form
{
    #[Url()]
    public $tabIndex = 0;
    public function ConvertShortcodeToHtml($content)
    {
        Shortcode::enable();
        $this->skipRender();
        return shortcodeRender($content);
    }
    public function getTemplates()
    {
        $this->skipRender();
        return TemplateBuilder::getTemplates();
    }
    protected function getView()
    {
        Assets::setTitle($this->getTitle());
        Theme::setLayout('none');
        breadcrumb()->title($this->getTitle())->breadcrumb($this->getBreadcrumb());
        return 'builder::components.builder';
    }
    protected function getPlugins()
    {
        return [[
            'name' => 'grapesjs-sokeio',
            'js' => [url('platform/modules/builder/grapesjs-sokeio/dist/index.js')],
            'css' => [],
            'options' => [
                'urlTemplateManager' => route('admin.builder.template-manager')
            ]
        ], ...applyFilters('SOKEIO_BUILDER_PLUGINS', [
            [
                'name' => 'gjs-blocks-basic',
                'js' => ['https://unpkg.com/grapesjs-blocks-basic'],
                'css' => [],
                'options' => [
                    'flexGrid' => true
                ]
            ],
            [
                'name' => 'grapesjs-plugin-forms',
                'js' => ['https://unpkg.com/grapesjs-plugin-forms'],
                'css' => [],
                'options' => []
            ],
            ...BuilderPlugin::query()->where('is_active', 1)->get()->map(function ($plugin) {
                return [
                    'name' => $plugin->name,
                    'js' => json_decode($plugin->js, true),
                    'css' => json_decode($plugin->css, true),
                    'options' => json_decode($plugin->options, true)
                ];
            })
        ])];
    }
    protected function getPageList()
    {
        return '';
    }
    protected function getLinkView()
    {
        return 'link-view';
    }
    protected function validateFail()
    {
        $this->tabIndex = 2;
    }
    public function render()
    {
        return view($this->getView(), [
            'title' => $this->getTitle(),

            'builder_version' => 'v1.0.0',
            'linkPageList' => $this->getPageList(),
            'linkView' => $this->getLinkView(),
            'tabs' => [
                [
                    'title' => __('Blocks'), 'view' => 'builder::tabs.block',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg"
                     class="icon icon-tabler icon-tabler-apps" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                <path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                <path d="M14 7l6 0"></path>
                <path d="M17 4l0 6"></path>
            </svg>'
                ],
                [
                    'title' => __('Templates'), 'template' => true,
                    'view' => 'builder::tabs.template',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg"
                     class="icon icon-tabler icon-tabler-carousel-vertical"
                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M19 8v8a1 1 0 0 1 -1 1h-12a1 1 0 0 1 -1 -1v-8a1 1 0 0 1 1 -1h12a1 1 0 0 1 1 1z"></path>
                <path d="M7 22v-1a1 1 0 0 1 1 -1h8a1 1 0 0 1 1 1v1"></path>
                <path d="M17 2v1a1 1 0 0 1 -1 1h-8a1 1 0 0 1 -1 -1v-1"></path>
            </svg>'
                ],
                [
                    'title' => __('Settings'),  'view' => 'builder::tabs.setting', 'data' => [
                        'layout' => $this->layout,
                        'footer' => $this->footer,
                    ], 'icon' => '<svg xmlns="http://www.w3.org/2000/svg"
                     class="icon icon-tabler icon-tabler-table-options"
                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 21h-7a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7"></path>
                <path d="M3 10h18"></path>
                <path d="M10 3v18"></path>
                <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                <path d="M19.001 15.5v1.5"></path>
                <path d="M19.001 21v1.5"></path>
                <path d="M22.032 17.25l-1.299 .75"></path>
                <path d="M17.27 20l-1.3 .75"></path>
                <path d="M15.97 17.25l1.3 .75"></path>
                <path d="M20.733 20l1.3 .75"></path>
            </svg>'
                ],
            ],
            'options' => [
                'pluginManager' => $this->getPlugins(),
                'blockManager' => [
                    'appendTo' => '.sokeio-builder-manager .block-manager',
                ],
                'selectorManager' => ['appendTo' => '.sokeio-builder-manager .selector-manager',],
                'styleManager' => [
                    'appendTo' => '.sokeio-builder-manager .style-manager',
                ],
                'layerManager' => [
                    'appendTo' => '.sokeio-builder-manager .layer-manager',
                ],
                'deviceManager' => [
                    // 'devices' => null
                    'appendTo' => '.sokeio-builder-manager .device-manager',
                ],
                'traitManager' => [
                    'appendTo' => '.sokeio-builder-manager .trait-manager',
                ],
                'panels' => [
                    'defaults' => [
                        [
                            'id' => 'options',
                            'el' => '.sokeio-builder-manager .options-panel-manager'
                        ],
                        [
                            'id' => 'devices-c',
                            'el' => '.sokeio-builder-manager .devices-panel-manager'
                        ]
                    ]
                ],
                'canvas' => [
                    'scripts' => ['https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js'],
                    'styles' => [
                        'https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css',
                        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css'
                    ],
                    'frameStyle' => '
                    body { background-color: #fff }
                    * ::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.1) }
                    * ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2) }
                    * ::-webkit-scrollbar { width: 10px }
                    *[data-gjs-type="shortcode"] {
                        padding: 4px;
                        border: 1px dashed #ccc;
                        background: #ddd;
                    }
                    *[data-gjs-type="shortcode"]:hover{
                        background: #61f1f1;
                    }
                  '
                ],
                'height' => '100%',
                'assetManager' => false,

                'storageManager' => false,

            ],
            'formUIClass' => $this->getFormClass()
        ]);
    }
}
