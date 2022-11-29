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

                    <!-- Start Box Body -->
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
                                    <label for="">Tags</label>
                                    <select class="form-control select2" name="tags[]" multiple v-model="item.tags">
                                        <option v-for="tag in tags" :value="tag.id"> {{ tag.name }} </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Images <small>(allows multiple images)</small></label>
                                    <input type="file" name="images[]" class="form-control input-sm" multiple>
                                </div>
                            </div>

                            <div class="col col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Content</label>
                                    <textarea class="content" name="content">{{ item.content }}</textarea>
                                </div>
                            </div>
                            
                            <div class="col col-xs-12 col-sm-12 col-md-12">
                                <images :items="item.photos" @on-delete="init"></images>
                            </div>
                            
                        </div>
                        <!-- End Row -->
                        
                    </div>
                    <!-- Box End -->
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Loader from '../../components/Loader.vue';
import flatpickr from '../../mixins/flatpickr.js';
import select2 from '../../mixins/select2.js';
import ckeditor from '../../mixins/ckeditor.js';

export default {
	props: {
        submiturl: String,
        fetchurl: String,
        disabled: Boolean,
        model: {},
    },

    components: {
        'loader': Loader
    },

    mixins: [
        ckeditor,
        flatpickr,
        select2,
    ],

    data() {
        return {
            loading: false,
            item: {},
            tags: []
    	}
    },

    computed: {
    	editable() {
    		return this.disabled;
    	},
    },

    mounted() {
    	this.setup();
    	this.init();
    },

    methods: {
    	setup() {
    		if (this.model) {
    			this.item = this.model ? this.model : {};
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
                this.item.tags = data.item ? data.item.tags : [];
                this.tags = data.tags;

                console.log(data.item);

    		}).catch(error => {
                console.log(error);
    		}).then(() => {
                this.load(false);
                this.select2.init('.select2');
            });
    	},

        load(value) {
            this.loading = value;
        }
    },
}
</script>