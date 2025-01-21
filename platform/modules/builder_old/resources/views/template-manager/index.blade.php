<div class="modal-body p-0"
    x-data='{
        templateCurrent:null,
        catagoryCurrent:"",
        searchText:"",
        templates:[],
        async loadTemplate(){
            this.templates= await this.$wire.getTemplates();
        },
        async getTemplateHtml(){
            return this.templateCurrent?.content??"";
        },
        getTemplates(){
            let self=this;
            return this.templates.filter((item, index) => {
                return (self.catagoryCurrent==""||self.catagoryCurrent==item.category)  && (
                    self.searchText==""||
                    item.category?.indexOf(self.searchText)>-1||
                    item.author?.indexOf(self.searchText)>-1||
                    item.topic?.indexOf(self.searchText)>-1||
                    item.email?.indexOf(self.searchText)>-1||
                    item.description?.indexOf(self.searchText)>-1||
                    item.template_name?.indexOf(self.searchText)>-1

                );
              });
        },
        chooseTemplate(item){
            if(this.templateCurrent==item){
                this.templateCurrent=null;
            }else{
                this.templateCurrent=item;
            }
        },
        getCatagorys(){
            return this.templates.map((item)=>{
                return item.category;
            }).filter((value, index, self) => {
                return self.indexOf(value) === index;
              });
        }
}'
    x-init="loadTemplate()">
    <div>
        <div class="row g-0">
            <div class="col">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link  text-uppercase text-center"
                            :class="catagoryCurrent == '' ? 'text-bg-primary ' : ''"
                            @click="catagoryCurrent='';templateCurrent=null;" aria-current="page" href="#">All</a>
                    </li>
                    <template x-for="item in getCatagorys()">
                        <li class="nav-item">
                            <a class="nav-link   text-uppercase text-center"
                                :class="catagoryCurrent == item ? ' text-bg-primary' : ''"
                                @click="catagoryCurrent=item;templateCurrent=null;" href="#"
                                x-text="item">Link</a>
                        </li>
                    </template>
                    <li class="nav-item p-1 w-auto">
                       
                            <input class=" form-control form-control-sm p-1" x-model="searchText"
                            placeholder="Search Template..." />
                      
                    </li>
                </ul>
            </div>
        </div>

        <div style="min-height: 400px;max-height:70vh; overflow:auto;">
            <div class="row g-0">
                <template x-for="item in getTemplates()" x-if="item?.template_name">
                    <div class="col-3  p-1">
                        <div class="border border-pink rounded-1" :class="item == templateCurrent ? 'border-2' : ''"
                            @click="chooseTemplate(item)">
                            @include('builder::template-manager.item')
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    <div class=" p-2 text-center  border-top-wide">
        <button :disabled="!templateCurrent" class=" btn btn-primary rounded-1"
            @click="{{ $callbackEvent }}(await getTemplateHtml())">Choose
            Template</button>
    </div>
</div>
