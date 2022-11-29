<template>
	<div>
        <div class="row">
    		<div class="col col-xs-12 col-sm-12 col-md-6">
    			<div class="form-group">
    				<label for="">Tenant ID</label>
    				<input type="text" class="form-control" placeholder="Tenant ID" v-model="item.tenant_id">
    				<input type="hidden" name="user_id" class="form-control" v-model="item.user.id">
    			</div>
    		</div>
    		<div class="col col-xs-12 col-sm-12 col-md-6">
    			<div class="form-group">
    				<label for="">Tenant Name</label>
    				<input type="text" class="form-control" placeholder="Tenant Name" v-model="item.name">
    			</div>
    		</div>
    		<div class="col col-xs-12 col-sm-12 col-md-6">
    			<div class="form-group">
    				<label for="">Duration</label>
    				<div class="input-group date">
                      	<div class="input-group-addon">
                        	<i class="fa fa-calendar"></i>
                      	</div>
                      	<input type="text" class="form-control pull-right" id="datepicker" placeholder="November 15, 2018 - December 17, 2018" v-model="item.duration">
                    </div>
    			</div>
    		</div>
    		<div class="col col-xs-12 col-sm-12 col-md-6">
    			<div class="form-group">
    				<label for="">Due Date</label>
    				<input type="text" class="form-control" v-model="item.duedate">
                  	<!-- <select class="form-control" name="due_date">
                  		<option v-for="(due_date, key) in item.due_date" :value="due_date">{{ due_date }}</option>
                  	</select> -->
    			</div>
    		</div>
    		<div class="col col-xs-12 col-sm-12 col-md-6">
    			<div class="form-group">
    				<label for="">Notes</label>
    				<input type="text" class="form-control" v-model="item.note">
    			</div>
    		</div>
    		<div class="col col-xs-12 col-sm-12 col-md-6">
    			<div class="form-group">
    				<label for="">Status</label>
    				<select class="form-control" name="status" v-model="item.status">
    					<option value="0">Unpaid</option>
    					<option value="1">Paid</option>
    				</select>
    			</div>
    		</div>
    		<div class="col col-xs-12 col-sm-12 col-md-6">
    			<div class="form-group">
    				<label for="">Payment Method</label>
                  	<select class="form-control" name="payment_method" v-model="item.invoice.payment_method">
    					<!-- <option value="1">Paypal</option> -->
                        <option value="3">Cash / Checks</option>
                        <option value="1" v-if="item.invoice.payment_method == 1" :selected="item.invoice.payment_method == 1">Paypal</option>
    				</select>
    			</div>
    		</div>
            <div class="col col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="">Payment Date</label>
                    <input type="date" class="form-control" name="payment_date" v-model="item.payment_date">
                </div>
            </div>
    		<div class="col col-xs-12 col-sm-12 col-md-6">
    			<div class="form-group">
    				<label for="">Amount <small>(need to be paid as of : Php {{ item.amount - item.invoice.amount }})</small></label>
                  	<input name="amount" type="text" class="form-control" v-model="item.invoice.amount">
    			</div>
    		</div>
    		<div class="col col-xs-12 col-sm-12 col-md-6">
    			<div class="form-group">
    				<label for="">Reference No.</label>
    				<input name="reference_code"  type="text" class="form-control" v-model="item.invoice.reference_code">
    			</div>
    		</div>
        </div>
        <button @click="updateBillingRent" class="btn btn-primary pull-left" style="margin-right: 5px" v-show="item.invoice.payment_method != 1">Saved</button>
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
        updateurl: String,
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

        updateBillingRent() {
            var data = {
                'amount' : parseInt(this.item.invoice.amount),
                'payment_date' : this.item.payment_date,
                'status' : parseInt(this.item.status),
            };

            swal({
                title: 'Update Rent',
                text: 'Are you sure you want to update this rent?',
                type: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: 'Yes, update it'
            })
            .then((result) => {
                if (result.value) {
                    swal({
                        title: 'Success',
                        text: 'Rent is updated!',
                        type: 'success',
                        showCancelButton: false,
                        reverseButtons: false,
                    })
                    .then((result) => {
                        axios.post(this.updateurl, data)
                        .then(response => {
                            this.fetch();
                        })
                    })
                }
            })
        }
    },
}
</script>