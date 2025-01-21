<div class="sokeio-builder-manager">
    <div class="sokeio-builder-header">
        <div class="sokeio-builder-header__left">
            <div class="sokeio-builder-logo">Sokeio builder <span>{{ $builder_version }}</span>
                <a href="{{ $linkPageList }}" class="text-white ms-4">Back</a>
                @if ($linkView)
                    <a href="{{ $linkView }}" class="text-white ms-4" target="_blank">View</a>
                @endif
            </div>
        </div>
        <div class="sokeio-builder-header__center">
            <div wire:ignore class="devices-panel-manager"></div>
        </div>
        <div class="sokeio-builder-header__right">
            <div wire:ignore class="options-panel-manager"></div>
        </div>
    </div>
    <div class="sokeio-builder-body">
        <div class="sokeio-builder-control" x-data="{
            controlTabIndex: @entangle('tabIndex').live,
            controlChooseTab: function(tab) {
                if (tab == this.controlTabIndex) {
                    this.controlTabIndex = -1;
                    return;
                } else {
                    this.controlTabIndex = tab;
                }
            }
        }">
            <div class="sokeio-builder-control__list">
                @foreach ($tabs as $key => $item)
                    <div title="{{ $item['title'] }}" @click="controlChooseTab({{ $key }})"
                        :class="controlTabIndex == {{ $key }} ? 'active' : ''"
                        class="sokeio-builder-control__list--item">
                        {!! $item['icon'] !!}
                    </div>
                @endforeach

            </div>
            <div class="sokeio-builder-control__content">
                @foreach ($tabs as $key => $item)
                    @if (isset($item['template']) && $item['template'] == true)
                        <template x-if="controlTabIndex=={{ $key }}">
                            @includeIf($item['view'], $item['data'] ?? [])
                        </template>
                    @else
                        <div x-show="controlTabIndex=={{ $key }}">
                            @includeIf($item['view'], $item['data'] ?? [])
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="sokeio-builder-content">
            <div wire:ignore wire:grapesjs wire:grapesjs.options='@json($options)'></div>
        </div>
        <div class="sokeio-builder-setting" wire:ignore>
            <div class="sokeio-builder-setting__component" x-data="{ tabIndex: 0 }">
                <div class="sokeio-builder-setting__component--tabs">
                    <div class="sokeio-builder-setting__component--tab" :class="tabIndex == 0 ? 'active' : ''"
                        @click="tabIndex=0">
                        Style
                    </div>
                    <div class="sokeio-builder-setting__component--tab" :class="tabIndex == 1 ? 'active' : ''"
                        @click="tabIndex=1">
                        Selector
                    </div>
                    <div class="sokeio-builder-setting__component--tab" :class="tabIndex == 2 ? 'active' : ''"
                        @click="tabIndex=2">
                        Setting
                    </div>
                    <div class="sokeio-builder-setting__component--tab" :class="tabIndex == 3 ? 'active' : ''"
                        @click="tabIndex=3">
                        Outline
                    </div>
                </div>
                <div class="sokeio-builder-setting__component--content">
                    <div x-show="tabIndex==0" class="style-manager manager-container">
                    </div>
                    <div x-show="tabIndex==1" class="selector-manager manager-container">
                    </div>
                    <div x-show="tabIndex==2" class="trait-manager manager-container">
                    </div>
                    <div x-show="tabIndex==3" class="layer-manager manager-container">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
