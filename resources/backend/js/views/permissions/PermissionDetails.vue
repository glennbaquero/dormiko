<template>
	<div>
		<div class="col col-xs-12 col-sm-12 col-md-4">
			<div class="form-group">
				<label for="">Firstname</label>
				<input name="firstname" type="text" class="form-control input-sm" v-model="item.firstname" placeholder="Firstname" :disabled="disabled">
			</div>
		</div>
		<div class="col col-xs-12 col-sm-12 col-md-4">
			<div class="form-group">
				<label for="">Lastname</label>
				<input name="lastname" type="text" class="form-control input-sm" v-model="item.lastname" placeholder="Lastname" :disabled="disabled">
			</div>
		</div>
		<div class="col col-xs-12 col-sm-12 col-md-4">
			<div class="form-group">
				<label for="">Email</label>
				<input name="email" type="text" class="form-control input-sm" v-model="item.email" placeholder="Email" :disabled="disabled">
			</div>
		</div>
		<div class="col col-xs-12 col-sm-12 col-md-4">
			<div class="form-group">
				<label for="">Contact No.</label>
				<input name="contact" type="text" class="form-control input-sm" v-model="item.contact" placeholder="Contact No." :disabled="disabled">
			</div>
		</div>
		<div class="col col-xs-12 col-sm-12 col-md-4">
			<div class="form-group">
				<label for="">Type</label>
				<select class="form-control" name="type" v-model="item.type" @change="adminType()" :disabled="disabled">
					<option value="0">Super Admin</option>
					<option value="1">Billing Officer</option>
				</select>
			</div>
		</div>
		<div class="col col-xs-12 col-sm-12 col-md-4" v-show="show">
			<div class="form-group">
				<label for="">Building Assignment</label>
				<select class="form-control" name="building_id" v-model="item.building_id" :required="item.type == 1">
					<option v-for="building in buildings" :value="building.id">{{ building.name }}</option>
				</select>
			</div>
		</div>
    </div>
</template>

<script>
import Loader from '../../components/Loader.vue';
import flatpickr from '../../mixins/flatpickr.js';
import select2 from '../../mixins/select2.js';
import ckeditor from '../../mixins/ckeditor.js';

	export default{
		props: {
			officer: Object,
			buildings: Array,
			disabled: Boolean
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

	            show: true
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
	    	this.adminType();
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
	            // this.load(true);
	            this.officer ? this.item = this.officer : this.item;
	    	},

	        load(value) {
	            this.loading = value;
	        },

	        adminType() {
	        	var type = parseInt(this.item.type);
	        	if(type === 0) {
	        		this.show = false;
	        	} else {
	        		this.show = true;
	        	}
	        }
	    },
	}
</script>