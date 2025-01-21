<div class="sokeio-builder-control__content--item">
    <h3> SEO Setting</h3>
    <div class="manager-body page-manager" wire:ignore>
        @if($form->seo_id)
        @livewire('admin::seo-box', ['dataId' => $form->seo_id])
        @endif
    </div>
</div>
