<template>
    <div>
        <loader
        :loading="loading"
        ></loader>

        <div class="row">
            <div class="col-md-12">
                <!-- Box Start -->
                <div class="box no-border box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-info-circle"></i>
                        <h3 class="box-title">Basic Information</h3>
                    </div>

                    <!-- Box Body Start -->
                	<div class="box-body">
                        <!-- Start Row -->
                        <div class="row">
                            <div class="col col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Header</label>
                                    <input v-model="item.header" :disabled="editable" name="header" type="text" class="form-control input-sm" placeholder="Header">
                                </div>
                            </div>

                            <div class="col col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <input v-model="item.description" :disabled="editable" name="description" type="text" class="form-control input-sm" placeholder="Description">
                                </div>
                            </div>

                            <div class="col col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input :disabled="editable" name="images[]" type="file" class="form-control input-sm" multiple>
                                </div>
                            </div>

                            <div class="col col-xs-12 col-sm-12 col-md-3" v-for="image in item.image_list">
                                <div class="form-group">
                                    <img :src="'storage/'+image.images.image" alt="" width="50%">
                                    <a :href="image.url" class="btn btn-sm btn-danger">x</a>
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

            item: {
                title: '',
            },
    	}
    },

    computed: {
    	editable() {
    		return this.disabled || this.loading;
    	},
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

    	fetch() {
            this.load(true);

    		axios.post(this.fetchurl)
    		.then(response => {
                const data = response.data;
                this.item = data.item ? data.item : {};
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