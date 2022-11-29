<template>
	<div>
		<div class="row">
			<loader
	        :loading="loading"
	        ></loader>
			
			<div class="col col-xs-12 col-sm-12 col-md-6">
				<div class="form-group">
					<input name="user_id" type="hidden" class="form-control input-sm" v-model="item.user_id" :readonly="disabled">
				</div>
			</div>
			<div class="col col-xs-12 col-sm-12 col-md-12">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label for="">Tenant ID<small>(Leaving in a blank will automatically generate id)</small></label>
							<input name="tenant_id" type="text" class="form-control input-sm" :value="item.user.user_detail.tenant_id">
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label for="">Name</label>
							<input name="firstname" type="text" class="form-control input-sm" :value="item.user.user_detail.firstname + ' ' + item.user.user_detail.lastname" :disabled="disabled">
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label for="">Gender</label>
							<select class="form-control input-sm" v-model="item.user.user_detail.gender" :disabled="disabled">
								<option value="1">Male</option>
								<option value="2">Female</option>
							</select>
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label for="">Contact No.</label>
							<input name="contact" type="text" class="form-control input-sm" :value="item.user.user_detail.contact" :disabled="disabled">
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label for="">Company</label>
							<input name="company" type="text" class="form-control input-sm" :value="item.user.user_detail.company" :disabled="disabled">
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label for="">Workplace Location</label>
							<input name="workplace" type="text" class="form-control input-sm" :value="item.user.user_detail.workplace" :disabled="disabled">
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label for="">Monthly Earning</label>
							<input name="monthly_earning" type="text" class="form-control input-sm" :value="item.user.user_detail.monthly_earning" :disabled="disabled">
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label for="">Move In</label>
							<input name="duration_from" type="text" class="form-control input-sm" :value="item.movein" :readonly="disabled">
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4">
						<!-- <div class="form-group">
							<label for="">Due Date</label>
							<input name="duration_to" type="text" class="form-control input-sm" :value="item.moveout" v-if="item.moveout" :readonly="disabled" required>
							<input name="duration_to" type="date" class="form-control input-sm" :min="movein" v-else required>
						</div> -->
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4" v-show="false">
						<div class="form-group">
							<label for="">Overnight</label>
							<input name="overnight" type="text" class="form-control input-sm" :value="item.moveout" :disabled="disabled">
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<label for="">Message</label>
							<input name="message" type="text" class="form-control input-sm" :value="item.message" :disabled="disabled">
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<label for="">Email</label>
							<input name="email" type="text" class="form-control input-sm w-25" v-model="item.user.email" :disabled="disabled">
						</div>
					</div>

					<div class="col col-xs-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label for="">Building</label>
							<!-- <input name="building" type="text" class="form-control input-sm" placeholder="Building"> -->
							<select class="form-control" id="room_type">
								<option>{{ item.building.name }}</option>
							</select>
						</div>
					</div>
					
					<div class="col col-xs-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label for="">Room Type</label>
							<!-- <input name="building" type="text" class="form-control input-sm" placeholder="Building"> -->
							<select class="form-control" v-model="item.selected_room_type" id="room_type">
								<option v-for="type in item.room_type" :value="type.value" v-if="type.value === item.selected_room_type">{{ type.label }}</option>
							</select>
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label for="">Unit No</label>
							<select class="form-control" name="room_id" v-model="item.room_id" id="room" required>
								<template v-for="unit in item.unit_no" v-if="item.selected_room_type === unit.room_type">
									<option :value="unit.id">{{ unit.unit_name }}</option>
								</template>
							</select>
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-6">
						<div class="form-group">
							<label for="">Uploaded File</label><br>
							<template v-if="item.user.documents.length === 0">To be follow</template>
							<template v-for="document in item.user.documents">
								<a :href="renderImage(document.path)">
									<img :src="renderImage(document.path)" width="21%" style="border-radius: 6px; width: 16%">
								</a>
							</template>
						</div>
					</div>
				</div>
			</div>
    	</div>
    	<button type="submit" class="btn btn-primary pull-left" style="margin-right: 5px" v-show="item.status == 0">Approved</button>
		<button class="btn btn-default pull-left" v-show="item.status == 0" @click="cancelReservation">Cancel</button>
		<!-- <success-modal-prompt></success-modal-prompt> -->
    </div>
</template>
<script>
import Loader from '../../components/Loader.vue';
import flatpickr from '../../mixins/flatpickr.js';
import select2 from '../../mixins/select2.js';
import ckeditor from '../../mixins/ckeditor.js';
import {EventBus} from '../../EventBus.js';
import SuccessModal from '../includes/SuccessModal.vue';
import ResponseHandler from '../../mixins/swal.js';
import moment from 'moment';

export default {

    mixins: [ ResponseHandler ],
	props: {
        submiturl: String,
        fetchurl: String,
        cancelurl: String,
        disabled: Boolean,
        model: {},
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
            item: {},
            movein: null,
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
                var d = this.item.movein.replace(' 00:00:00','');
	    		this.movein = d;
				EventBus.$emit('success-modal');
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

        renderImage(img) {
        	return 'storage/'+img;
        },

        cancelReservation() {
        	var data = new FormData();

        	data.append('status', 2);

        	swal({
        	    title: 'Cancellation of Application',
        	    text: 'Are you sure you want to cancel this applicant?',
        	    type: 'warning',
        	    showCancelButton: true,
        	    reverseButtons: true,
        	    confirmButtonText: 'Yes, cancel it'
        	})
        	.then((result) => {
        	    if (result.value) {
		        	this.load(true);
                	axios.post(this.cancelurl, data)
            		.then(response => {
    	                this.load(false);
    					// EventBus.$emit('success-modal', 'message');
    					swal({
    	                    title: 'Success',
    	                    text: 'Applicant cancelled!',
    	                    type: 'success',
    	                    showCancelButton: false,
    	                    reverseButtons: false,
    	                }).then((result) => {
    						location.reload();
    	                })
            		})
        	    }
        	})
        },
    },
}
</script>