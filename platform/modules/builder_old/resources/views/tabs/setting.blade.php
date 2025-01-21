<div class="sokeio-builder-control__content--item">
    <h3> Page Setting</h3>
    <div class="manager-body page-manager">
        <div @if ($formUIClass) class="{{ $formUIClass }}" @endif>
            @includeIf('sokeio::components.layout', ['layout' => $layout])
            @includeIf('sokeio::components.layout', ['layout' => $footer])
        </div>
    </div>
</div>
