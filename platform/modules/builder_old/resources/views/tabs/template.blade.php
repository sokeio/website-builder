<div class="sokeio-builder-control__content--item">
    <h3>Template Manager</h3>
    <div class="manager-body template-page-manager"
        x-data='{
    templates: [],
    itemCataShow: [],
    searchText:"",
    async loadTemplate(){
        this.templates= await this.$wire.getTemplates();
    },
    getTemplates(itemCata="") {
        let self=this;
        let rs= this.templates?.filter((item, index) => {
            return (itemCata==""||itemCata==item.category)  && (
                self.searchText===""||
                item.category?.indexOf(self.searchText)>-1||
                item.author?.indexOf(self.searchText)>-1||
                item.topic?.indexOf(self.searchText)>-1||
                item.email?.indexOf(self.searchText)>-1||
                item.description?.indexOf(self.searchText)>-1||
                item.template_name?.indexOf(self.searchText)>-1
            );
          });
        return rs??[];
    },
    getCatagorys(){
        return (this.getTemplates("")?.map((item)=>{
            return item.category;
        })?.filter((value, index, self) => {
            return self.indexOf(value) === index;
          }))??[];
    }
}'
        x-init="loadTemplate()">
        <input class=" form-control" x-model="searchText" placeholder="Search Template..." />
        <div class="mt-2" wire:ignore>
            <template x-for="(itemCata,index) in getCatagorys()">
                <div class="card rounded-1 mb-2 p-0 border-blue">
                    <button @click=" itemCataShow[itemCata] = ! itemCataShow[itemCata] "
                        class=" card-title m-0 rounded-0 p-1 text-bg-primary text-uppercase text-center"
                        x-html="itemCata">
                        Featured
                    </button>
                    <div class="card-body p-1" x-show="itemCataShow[itemCata]">
                        <template x-for="item in getTemplates(itemCata)">
                            <template x-if="item?.template_name">
                                <div class="item-box mb-1 border" draggable="true"
                                    x-on:dragstart.self="
        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/html', item.content);
      ">
                                    @include('builder::template-manager.item')
                                </div>
                            </template>
                        </template>
                    </div>
                </div>
            </template>
        </div>

    </div>
</div>
