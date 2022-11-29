<template>
	<div>
        <loader
        :loading="loading"
        ></loader>
		<div class="col-md-6">
          	<div class="box box-solid">
            	<div class="box-header with-border" style="padding: 8px 0px 4px 18px">
                    <label>Upload Document</label>
                </div>
                <div class="box-body with-border">
            		<div class="row">
            			<div class="col-md-12">
                            <div class="form-group" style="margin-left: 9%">
                                <p>Document Name</p>
                                <input type="text" name="name" class="text-box" style="width: 89%;">
                            </div>
		                </div>
                        <div class="col-md-12">
                            <div class="form-group" style="margin-left: 9%">
                                <p>File</p>
                                <input type="file" name="path" class="text-box" style="width: 89%;">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" style="margin-left: 9%">
                                <!-- <button class="btn-submit btn-primary" @click="submit">Submit</button> -->
                                <button class="btn-submit btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
            		</div>
            	</div>
          	</div>
        </div>
        <div class="col-md-6" v-for="item in items">
          	<div class="box box-solid">
            	<div class="box-header with-border">
            		<div class="row">
						<div class="col-md-12">
						  <center>
                                <p>Document Name</p>
                                <a :href="locate(item.path)"><h4><b>{{ item.name }}</b></h4></a>
                          </center>
						</div>
						
						</div>
					</div>
	            </div>
         	</div>
        </div>
	</div>
</template>

<script>
import Loader from '../../../components/Loader.vue';
import flatpickr from '../../../mixins/flatpickr.js';
import select2 from '../../../mixins/select2.js';
import ckeditor from '../../../mixins/ckeditor.js';

export default {
    props: {
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
            items: {},
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
                this.items = this.model ? this.model : {};
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
                this.items = data.items ? data.items : {};
            }).catch(error => {
                console.log(error);
            }).then(() => {
                this.load(false);
                this.select2.init('.select2');
            });
        },

        load(value) {
            this.loading = value;
        },

        locate(file)  {
            return 'storage/'+file;
        }
    },
}
</script>