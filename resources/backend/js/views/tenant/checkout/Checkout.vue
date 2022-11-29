<template>
	<div>
        <div class="box box-widget nav-tabs-custom">
            <ul class="nav nav-tabs">
                <!-- <li class="active">
                    <a href="#ipay88" data-toggle="tab" @click="buildItems(0)"><h5><b>iPay88</b></h5></a>
                </li> -->
                <li class="active">
                    <a href="#paypal" data-toggle="tab" @click="buildItems(1)"><h5><b>Paypal</b></h5></a>
                </li>
            </ul>  
            <div class="box box-widget nav-tabs-custom table-responsive">
                <div class="tab-content">
                    <!-- <div class="tab-pane active" id="ipay88">
						<p>You can pay your money through iPay88, for more info <a>click here</a></p>
                        <a class="btn btn-danger btn-flat btn-lg">Pay with iPay88</a>	                    	
                    </div> -->
                    <div class="tab-pane active" id="paypal">
						<p>You can pay your money through Paypal, for more info <a href="https://www.paypal.com/ph/webapps/mpp/pay-online" target="_blank">click here</a></p>
						<button class="btn btn-danger btn-flat btn-lg" @click="processCheckout()">Pay with Paypal</button>
                    </div>  
                    <div class="tab-pane" id="bank-deposit">
                    	
                    </div>                
                </div>
    	    </div>     
        </div> 
        <div class="box box-widget">
        	<div class="box-body">
        		<div class="col-md-4">
        			<label>Amount </label>
        			<p> &#8369; {{ item.amount }}</p>
        		</div>
        		<div class="col-md-4">
        			<label>Duration </label>
        			<p>{{ item.duration }}</p>
        		</div>
        		<div class="col-md-4">
        			<label>Due Date </label>
        			<p>{{ item.duedate }}</p>
        		</div>
        	</div>
        </div>               
	</div>
</template>
<script>
	import prx_paypal_mixin from '../../../../../../public/vendor/praxxys/ecommerce/paypal/js/vue-mixin.js';
	import Loader from '../../../components/Loader.vue';

	export default {
		mixins: [prx_paypal_mixin],

		props: {
			fetchurl: String,
			checkouturl: String
		},

	    components: {
	        'loader': Loader
	    },

		data() {
			return {
				loading: false,
	            item: {},
	            payment_method: 1,
			}
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
	    	},

	    	init() {
	    		this.fetch();
		    	this.buildItems();
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
	        },

	        processCheckout() {
	        	var data = new FormData();
	        	var total;
	        	if(this.item.billing_rent) {
		        	total = parseInt(this.item.billing_rent.penalty) + parseInt(this.item.amount);
	        	} else {
	        		total = total = parseInt(this.item.amount);
	        	}

	        	data.append('amount', total);
	        	data.append('payment_method', this.payment_method);
	        	data.append('id', this.item.id);
	        	axios.post(this.checkouturl, data)
	        		.then(response => {
	        			this.PRXPayPalSubmit(this.buildItems(), response.data.invoice.reference, response.data.invoice.currency);
	        		})
	        },

	        buildItems() {
	        	const items = [];
	        	var total;
	        	if(this.item.billing_rent) {
	        		total = parseInt(this.item.billing_rent.penalty) + parseInt(this.item.amount);
	        	} else {
	        		total = parseInt(this.item.amount);
	        	}
	        	
	        	items.push({name: this.item.tenant_id, price: total, qty: 1});
	        	return items;
	        }
		}
	}
</script>