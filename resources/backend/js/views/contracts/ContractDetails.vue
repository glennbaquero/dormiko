<template>
	<div>
		<div class="row">
			<div class="col-md-5">
				<div class="box box-default">
		            <div class="box-body">
		              <div class="row">
		                <div class="col-md-4">
		                	<img src="storage/admin.png" class="img-responsive img-circle">
		                </div>
		                <div class="col-md-8">
							<h3>{{ item.user.user_detail.lastname }}, {{ item.user.user_detail.firstname }} {{ item.user.user_detail.middlename }}</h3>
							<p>{{ item.user.user_detail.tenant_id }}</p>
		                </div>
		              </div>
		            </div>
		            <div class=" no-padding">
		              <div class="row" style="margin: 0%; margin-left: 1%;">
		              	<div class="col-md-6">
		              		<div class="row">
		              			<div class="col-md-12">
				              		<h4>Rental Agreement</h4>
				              		<h4>Status</h4>
				              		<h4>Building</h4>
				              		<h4>Unit No.</h4>
				              		<h4>Contract Start</h4>
				              		<h4>Contract End</h4>
				              	</div>
		              		</div>
		              	</div>
		              	<div class="col-md-6">
		              		<div class="row">
		              			<div class="col-md-12">
									<a :href="printcontract" class="btn btn-primary">View Contract</a>
									<label class="text-success">Outstanding</label>
									<p>{{ item.room.building.name }}</p>
									<p>{{ item.room.unit_name }}</p>
									<p>{{ item.extracted_date_from }}</p>
									<p>{{ item.extracted_date_to }}</p>
		              			</div>
		              		</div>
		              	</div>
		              </div>
		            </div>
		        </div>
          	</div>
          	<div class="col-md-7">
          		<div class="box box-default">
		            <div class="box-body">
		              	<div class="row">
			                <div class="col-md-8" v-if="!edit">
								<label style="font-size: 23px">Personal Information</label>
								<p><b>Tenant Name</b></p>
								<p>{{ item.user.user_detail.lastname }}, {{ item.user.user_detail.firstname }} {{ item.user.user_detail.middlename }}</p>
								<div class="row">
									<div class="col-md-4">
										<p><b>Birthdate</b></p>
									</div>
									<div class="col-md-4">
										<p><b>Contact No.</b></p>
									</div>
									<div class="col-md-4">
										<p><b>Email</b></p>
									</div>
									<div class="col-md-4">
										<p>{{ item.birthdate }}</p>
									</div>
									<div class="col-md-4">
										<p>{{ item.user.user_detail.contact }}</p>
									</div>
									<div class="col-md-4">
										<p>{{ item.user.email }}</p>
									</div>
									</div>
										<p><b>Address</b></p>
										<p>{{ item.user.user_detail.address }}</p>
					            </div>
								
								<!-- edit -->
								<!-- <update-info v-if="edit" :item="item"></update-info> -->

					           <!--  <div class="col-md-4">
									<a class="btn btn-primary" @click="editinfo()">Edit</a>
				                </div> -->
				              	</div>
				            </div>
			       		</div>
		            </div>

		        <div class="col-md-7" v-for="list in item.lists">
	          		<div class="box box-default">
			            <div class="box-body">
			              	<div class="row">
				                <div class="col-md-8" v-if="!edit">
									<label style="font-size: 23px">Joiners Information</label>
									<p><b>Tenant Name</b></p>
									<p>{{ list.lastname }}, {{ list.firstname }} {{ list.middlename }}</p>
									<div class="row">
										<div class="col-md-4">
											<p><b>Birthdate : {{ list.birthdate }}</b></p>
										</div>
										<div class="col-md-4">
											<p><b>Contact No. : {{ list.contact }}</b></p>
										</div>
										<div class="col-md-4">
											<p><b>Gender : {{ list.gender === 1 ? 'Male' : 'Female' }}</b></p>
										</div>
									</div>
									<p><b>Address</b></p>
									<p>{{ list.address }}</p>
						        </div>
								<!-- <update-info v-if="edit" :item="list"></update-info> -->

					            <!-- <div class="col-md-4">
									<a class="btn btn-primary" @click="editinfo()">Edit</a>
				                </div> -->
				              	</div>
				            </div>
				       	</div>
		            </div>

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
import UpdateInfo from './UpdateTenantInfo.vue';

export default {
	props: {
        submiturl: String,
        fetchurl: String,
        disabled: Boolean,
        model: {},
        printcontract: String,
    },

    components: {
        'loader': Loader,
        'update-info': UpdateInfo
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
            edit: false
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

        editinfo() {
        	if(this.edit) {
	        	this.edit = false;
        	} else {
	        	this.edit = true;
        	}
        }
    },
}
</script>