<template>
	<div>
		<div class="col col-xs-12 col-sm-12 col-md-4">
			<div class="form-group">
				<label for="">Unit Name</label>
				<input name="unit_name" type="text" class="form-control input-sm" v-model="item.unit_name" placeholder="Unit Name">
				<input name="building_id" type="hidden" class="form-control input-sm" v-model="item.building_id">
				<input name="floor" type="hidden" class="form-control input-sm" v-model="floor">
			</div>
			<div class="form-group">
				<label for="">Room Type</label>
				<select class="form-control" name="room_type" v-model="item.room_type">
					<option value="1">Dorm</option>
					<option value="2">Studio</option>
				</select>
			</div>
			<div class="form-group">
				<label for="">Preferred Gender Occupant</label>
				<select class="form-control" name="prefer_tenant_gender" v-model="item.prefer_tenant_gender">
					<option value="0">Male</option>
					<option value="1">Female</option>
					<option value="2">Mix</option>
				</select>
			</div>
			<div class="form-group">
                <label for="">Room Image</label>
                <input name="image" type="file" class="form-control input-sm" placeholder="Image">
            </div>

		</div>
		<div class="col col-xs-12 col-sm-12 col-md-4">
			<div class="form-group">
				<label for="">Price</label>
				<input name="price_range_from" type="number" class="form-control input-sm" v-model="item.price_range_from">
			</div>
			<!-- <div class="form-group">
				<label for="">Price Range To</label>
				<input name="price_range_to" type="number" class="form-control input-sm" v-model="item.price_range_to">
			</div> -->
			<div class="form-group">
				<label for="">Beds</label>
				<input name="beds" type="number" class="form-control input-sm" placeholder="Bed" v-model="item.beds">
			</div>
			<div class="form-group">
				<label for="">Status</label>
				<select class="form-control" name="status" v-model="item.status">
					<option value="0">Occupied</option>
					<option value="1">Available</option>
				</select>
			</div>
		</div>

		<div class="col col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="content">{{ item.description }}</textarea>
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
			building_id: Number,
			floor: Number,
			room: Object,
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
	            item: {
	            	building_id: this.building_id,
	            },
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
	            // this.load(true);
	            this.room ? this.item = this.room : this.item;
	    	},

	        load(value) {
	            this.loading = value;
	        }
	    },
	}
</script>