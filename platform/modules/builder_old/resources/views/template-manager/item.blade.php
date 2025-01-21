<div class=" position-relative" :title="item.template_name">
    <template x-if="item.thumbnail">
        <div :style='"background-repeat: no-repeat; background-size: cover;height: 180px;background-position: center;width: 99%; background-image: url(" +
        item.thumbnail + "); "'
            class="template-preview"></div>
    </template>
    <template x-if="!item.thumbnail">
        <svg xmlns="http://www.w3.org/2000/svg" class="template-preview" viewBox="0 0 1300 1100" width="99%"
            height="180">
            <foreignObject width="100%" height="100%" style="pointer-events:none">
                <div xmlns="http://www.w3.org/1999/xhtml" x-html="item.content">
                </div>
            </foreignObject>
        </svg>
    </template>
    <template x-if="item.template_type&&item.template_type==='community'">
        <div class="ribbon bg-success text-success" x-html="item.template_type">Community</div>
    </template>
    <template x-if="item.template_type&&item.template_type==='database'">
        <div class="ribbon bg-gray text-gray">Database</div>
    </template>
    <template x-if="item.template_type&&item.template_type==='free'">
        <div class="ribbon  bg-muted text-muted-fg" x-html="item.template_type">Pro</div>
    </template>
    <template x-if="item.template_type&&item.template_type=='pro'">
        <div class="ribbon bg-warning" x-html="item.template_type">Pro</div>
    </template>
</div>
