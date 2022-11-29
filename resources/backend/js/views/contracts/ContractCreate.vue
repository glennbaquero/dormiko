<template>
	<div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<loader
				        :loading="loading"
				        ></loader>
						
						<div class="col col-xs-12 col-sm-12 col-md-12">
							<div class="row">
								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Tenant ID <small>(Leaving in a blank will automatically generate id)</small></label>
										<input name="tenant_id" type="text" class="form-control input-md" v-model="item.userinfo.tenant_id">
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Firstname</label>
										<input name="firstname" type="text" class="form-control input-md" v-model="item.userinfo.firstname" required>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Lastname</label>
										<input name="lastname" type="text" class="form-control input-md" v-model="item.userinfo.lastname" required>
									</div>
								</div>

								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Email</label>
										<input name="email" type="text" class="form-control input-md" v-model="item.user.email" required>
									</div>
								</div>

								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Gender</label>
										<select name="gender" class="form-control input-md" v-model="item.userinfo.gender" required>
											<option value="0">Male</option>
											<option value="1">Female</option>
										</select>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Contact No.</label>
										<input name="contact" type="text" class="form-control input-md" v-model="item.userinfo.contact" required>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Company</label>
										<input name="company" type="text" class="form-control input-md" v-model="item.userinfo.company" required>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Workplace Location</label>
										<input name="workplace" type="text" class="form-control input-md" v-model="item.userinfo.workplace" required>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Monthly Earning</label>
										<input name="monthly_earning" type="text" class="form-control input-md" v-model="item.userinfo.monthly_earning" required>
									</div>
								</div>
								<!-- <div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Overnight</label>
										<select name="overnight" class="form-control" id="room_type" v-model="item.reservation.overnight" @change="overnightStay(item.reservation.overnight)" required>
											<option value="0">No</option>
											<option value="1">Yes</option>
										</select>
									</div>
								</div> -->
								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Move In</label>
										<input name="movein" type="date" class="form-control input-md" v-model="item.move_in" required>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Move Out</label>
										<input name="moveout" type="date" class="form-control input-md" :disabled="overnight" v-model="item.move_out" disabled>
									</div>
								</div>

								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Building</label>
										<select name="building_id" class="form-control" id="room_type" v-model="item.room.building.id" required>
											<template v-if="Array.isArray(buildings)" v-for="building in buildings">
												<option :value="building.id">{{ building.name }}</option>
											</template>
											<template v-if="Object(buildings)">
												<option :value="buildings.id">{{ buildings.name }}</option>
											</template>
										</select>
									</div>
								</div>
								
								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Room Type</label>
										<select name="room_type" class="form-control" id="room_type" v-model="item.room.room_type" required>
											<option value="1">DORM</option>
											<option value="2">STUDIO</option>
										</select>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4">
									<div class="form-group">
										<label for="">Unit No</label>
										<select name="room_id" class="form-control" id="room" v-model="item.room.id" required>
											<template v-if="Array.isArray(buildings)" v-for="building in buildings">
												<option v-for="room in building.rooms" v-if="room.building_id === item.room.building.id && room.room_type === parseInt(item.room.room_type)" :value="room.id">{{ room.unit_name }}</option>
											</template>
											<template v-if="Object(buildings)">
												<option v-for="room in rooms" v-if="room.building_id === item.room.building.id && room.room_type === parseInt(item.room.room_type)" :value="room.id">{{ room.unit_name }}</option>
											</template>
										</select>
									</div>
								</div>
							</div>
						</div>
			    	</div>
        		</div>
        	</div>
			<button @click="showMessage" name="renew" class="btn btn-primary pull-left" style="margin-right: 5px">Submit</button>
	    </div>
		<success-modal-prompt></success-modal-prompt>
    </div>
</template>
<script>
import Loader from '../../components/Loader.vue';
import flatpickr from '../../mixins/flatpickr.js';
import select2 from '../../mixins/select2.js';
import ckeditor from '../../mixins/ckeditor.js';
import {EventBus} from '../../EventBus.js';
import SuccessModal from '../includes/SuccessModal.vue';

export default {
	props: {
        submiturl: String,
        fetchurl: String,
        cancelurl: String,
        disabled: Boolean,
        buildings: Array,
        rooms: Object,
        model: {},
        url: String,
        update: Boolean
    },

    components: {
        'loader': Loader,
        'success-modal-prompt' : SuccessModal
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
            	userinfo: {
            		tenant_id: null,
            		firstname: null,
            		lastname: null,
            		gender: 0,
            		contact: null,
            		company: null,
            		workplace: null,
            		monthly_earning: null,
            	},
            	user: {
            		email: null,
            	},
        		reservation: {
        			overnight: 0
        		},
        		room: {
        			room_type: null,
        			building: {
        				id: 1
        			}
        		},

        		move_in: null,
        		move_out: null,
            },
            overnight: false
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
                this.item = data.item ? data.item : this.item;
				// EventBus.$emit('success-modal');

    		}).catch(error => {
                console.log(error);
    		}).then(() => {
                this.load(false);
                this.select2.init('.select2');
            });
            this.load(false);
    	},

        load(value) {
            this.loading = value;
        },

        overnightStay(overnight) {
        	if(parseInt(overnight) === 1) {
        		this.overnight = true;
        	} else {
        		this.overnight = false;
        	}
        },

        showMessage() {
    		if(this.update) {
    			swal({
    				title: 'Update tenant info',
    	            text: 'Are you sure you want to update this tenant?',
    	            type: 'warning',
    	            showCancelButton: true,
    	            reverseButtons: true,
    	            confirmButtonText: 'Yes, update it!'
    	        }).then((result) => {
    	            if (result.value) {
    	                this.saveData();
    	            }
    	        })
    		} else {
    			this.saveData();
    		}
        },

        saveData() {
        	var data = {
        		firstname: this.item.userinfo.firstname,
        		lastname: this.item.userinfo.lastname,
        		email: this.item.user.email,
        		gender: this.item.userinfo.gender,
        		contact: this.item.userinfo.contact,
        		company: this.item.userinfo.company,
        		workplace: this.item.userinfo.workplace,
        		monthly_earning: this.item.userinfo.monthly_earning,
        		overnight: this.item.reservation.overnight,
        		movein: this.item.move_in,
        		moveout: this.item.move_out,
        		building_id: this.item.room.building.id,
        		room_type: this.item.room.room_type,
        		room_id: this.item.room.id,
                tenant_id: this.item.userinfo.tenant_id
        	}

        	axios.post(this.url, data)
        		.then(response => {
        			swal(response.data.header, response.data.message, response.data.type);
        			this.fetch();
        		})
        }
    },
}
</script>