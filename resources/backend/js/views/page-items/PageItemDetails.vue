<template>
    <div>
        <loader
        :loading="loading"
        ></loader>

        <div class="row">
            <div class="col-md-12">
                <!-- Box Start -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-info-circle"></i>
                        <h3 class="box-title">Basic Information</h3>
                    </div>

                    <!-- Box Body Start -->
                	<div class="box-body">
                        <!-- Start Row -->
                        <div class="row">

                            <div class="col col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Page <small class="text-danger">(WARNING: avoid editing may cause errors)</small></label>
                                    <select v-model="item.page_id" @change="change" :disabled="editable" name="page_id" class="form-control input-sm">

                                        <option :value="undefined">Select a Page</option>

                                        <template v-for="page in pages">

                                            <option :value="page.id">{{ page.name }}</option>

                                        </template>
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Slug <small class="text-danger">(WARNING: avoid editing may cause errors)</small></label>
                                    <input v-model="item.slug" :disabled="editable" name="slug" type="text" class="form-control input-sm" placeholder="Slug">
                                </div>
                            </div>

                            <div class="col col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Type <small class="text-danger">(WARNING: avoid editing may cause errors)</small></label>
                                    <select v-model="selectedType" :disabled="editable" name="type" class="form-control input-sm">

                                        <option :value="null">Select a Type</option>

                                        <template v-for="type in types">

                                            <option :value="type.value">{{ type.label }}</option>

                                        </template>
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col col-xs-12 col-sm-12 col-md-12">
                                <div v-if="isText || isFile" class="form-group">
                                    <label>Content <a v-show="isFile && item.file" :href="item.file" class="btn btn-xs btn-primary" target="_blank">View File</a></label>
                                    <input v-if="isText" v-model="item.content" :disabled="editable" name="content" type="text" class="form-control input-sm" placeholder="Content" required>
                                    <input v-if="isFile" :disabled="editable" name="content" type="file" class="form-control input-sm" required>
                                </div>

                                <div v-if="isContent" class="form-group">
                                    <label>Content</label>
                                    <textarea v-if="isContent" :disabled="editable" name="content" class="content form-control input-sm" placeholder="Content" required>{{ item.content }}</textarea>
                                </div>
                            </div>

                                

                        </div>
                        <!-- End Row -->
                		
                    <!-- Box Body End -->
                    </div>
                </div>
            <!-- Box End -->
            </div>
        </div>
    </div>
</template>

<script>
import Loader from '../../components/Loader.vue';
import ckeditor from '../../mixins/ckeditor.js';

export default {
    props: {
        submiturl: String,
        fetchurl: String,
        disabled: Boolean,
        model: {
            type: Object,
        },
    },

    components: {
        'loader': Loader,
    },

    mixins: [
        ckeditor,
    ],

    data() {
        return {
            loading: false,

            selectedType: null,

            types: [],
            pages: [],
            item: {
                title: '',
            },
        }
    },

    computed: {
        editable() {
            return this.disabled || this.loading;
        },

        isText() {
            return this.compareArrayValue(this.selectedType, 'Text/Link/Label', this.types);
        },

        isContent() {
            return this.compareArrayValue(this.selectedType, 'Content/Editor', this.types);
        },

        isFile() {
            return this.compareArrayValue(this.selectedType, 'Image/File', this.types);
        },
    },

    watch: {
        selectedType(val) {
            if(this.isContent) {
                this.change();
            } else {
                CKEDITOR.instances.content.destroy();
            }
        }
    },

    mounted() {
        this.setup();
        this.init();
    },

    methods: {
        setup() {
            if (this.model) {
                this.item = this.model;
            }

            this.ckeditor.init();
        },

        init() {
            this.fetch();

        },

        setType() {
            if (!this.item) {
                this.selectedType = this.types[0].value;
            } else {
                this.selectedType = this.item.type;
            }
        },

        change() {
            this.$nextTick(() => {
                if (this.isContent) {
                    this.ckeditor.init();
                }
            });
        },

        fetch() {
            this.load(true);

            axios.post(this.fetchurl)
            .then(response => {
                const data = response.data;
                this.item = data.item ? data.item : {};
                this.pages = data.pages;
                this.types = data.types;
                this.setType();

            }).catch(error => {
                console.log(error);
            }).then(() => {
                this.load(false);
            });
        },

        load(value) {
            this.loading = value;
        }
    },
}
</script>