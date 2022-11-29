<template>
	<div>
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
		<!-- <div class="col col-xs-12 col-sm-12 col-md-6">
			<div class="form-group">
				<label for="">Utility Type</label>
				<select class="form-control">
					<option>Water</option>
				</select>
			</div>
		</div> -->
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
				<label for="">Paid Date</label>
				<input type="text" class="form-control" v-model="item.payment_date">
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
              	<select class="form-control" name="payment_method" v-model="item.payment_method">
					<option value="3">Cash</option>
				</select>
			</div>
		</div>
		<div class="col col-xs-12 col-sm-12 col-md-6">
			<div class="form-group">
				<label for="">Amount</label>
              	<input name="amount" type="text" class="form-control" v-model="item.amount">
			</div>
		</div>
		<div class="col col-xs-12 col-sm-12 col-md-6">
			<div class="form-group">
				<label for="">Reference No.</label>
				<input name="reference_code"  type="text" class="form-control" v-model="item.reference_code">
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
    },
}
</script>