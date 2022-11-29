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
                                    <label for="">Name</label>
                                    <input v-model="item.name" :disabled="editable" name="name" type="text" class="form-control input-sm" placeholder="Name">
                                </div>
                            </div>

                            <div class="col col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Slug <small class="text-danger">(WARNING: avoid editing may cause errors)</small></label>
                                    <input v-model="item.slug" :disabled="editable" name="slug" type="text" class="form-control input-sm" placeholder="Slug">
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