<template>
	<div>
		<div class="col-md-6">
          	<div class="box box-solid">
            	<div class="box-header with-border">
            		<div class="row">
            			<div class="col-md-6">
		                	<img src="storage/admin.png" class="img-responsive img-circle">
		                </div>
		                <div class="col-md-6">
		                	<h3><label>{{ item.details.firstname }} {{ item.details.lastname }}</label></h3>
		                	<p>{{ item.user.email }}</p>
		                </div>
		           <!--      <div class="col-md-8">
		                	<h4><p>Rental Agreement</p></h4> 
		                	<h4><p>Status</p></h4> 
		                	<h4><p>Building</p></h4> 
		                	<h4><p>Unit No.</p></h4> 
		                </div>
		                <div class="col-md-4" v-for="contract in item.contracts">
		                	<button type="submit" class="btn btn-primary">View Contract</button>
		                	<h4><p>{{ contract.status }}</p></h4> 
		                	<h4><p>Building</p></h4> 
		                	<h4><p>Unit No.</p></h4> 
		                </div> -->
            		</div>
            	</div>
          	</div>
        </div>

        <div class="col-md-6">
          	<div class="box box-solid">
            	<div class="box-header with-border">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<button class="btn btn-flat pull-right" v-show="disabled" @click="edit">Edit</button>
								<button class="btn btn-flat pull-right" v-show="!disabled" @click="save">Save</button>
							</div>
						</div>
					</div>
            		<div class="row">
						
						<div class="col-md-4">
							<div class="form-group">
								<label>Lastname *</label>
								<input type="text" class="form-control" style="border: 1px solid; border-radius: 0px" v-model="item.details.lastname" :disabled="disabled">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Firstname *</label>
								<input type="text" class="form-control" style="border: 1px solid; border-radius: 0px" v-model="item.details.firstname" :disabled="disabled">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Middlename</label>
								<input type="text" class="form-control" style="border: 1px solid; border-radius: 0px" v-model="item.details.middlename" :disabled="disabled">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Birthdate *</label>
								<input type="date" class="form-control" style="border: 1px solid; border-radius: 0px" v-model="birthdate" :disabled="disabled">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Contact No. *</label>
								<input type="text" class="form-control" style="border: 1px solid; border-radius: 0px" v-model="item.details.contact":disabled="disabled">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Email *</label>
								<input type="text" class="form-control" style="border: 1px solid; border-radius: 0px" v-model="item.user.email" disabled="true">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Address *</label>
								<input type="text" class="form-control" style="border: 1px solid; border-radius: 0px" v-model="item.details.address":disabled="disabled">
							</div>
						</div>
						<hr size="30">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<button class="btn btn-flat pull-right" v-show="!show" @click="show = true">Change Password</button>
									<button class="btn btn-flat pull-right" v-show="show" @click="savechanges">Save Changes</button>
								</div>
							</div>
						</div>
						<div v-show="show">
							<div class="col-md-12">
								<div class="form-group">
									<label>Old Password</label>
									<input type="password" class="form-control w-100" style="border: 1px solid; border-radius: 0px" v-model="item.old_password">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>New Password</label>
									<input type="password" class="form-control w-100" style="border: 1px solid; border-radius: 0px" v-model="item.password">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Confirm Password</label>
									<input type="password" class="form-control w-100" style="border: 1px solid; border-radius: 0px" v-model="item.password_confirmation">
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
	export default{
		props: {
			user: Object,
			details: Object,
			contracts: Array,
			updateurl: String,
			updatepasswordurl: String
		},

		data() {
			return {
				item:{
					user: this.user,
					details: this.details,
					contracts: this.contracts
				},

				disabled: true,
				show: false,
				birthdate: null
			}
		},

		mounted() {
			this.birthdate =  moment(this.item.details.birthdate).format('YYYY-MM-DD');
		},

		methods: {
			edit() {
				this.disabled = false;
			},

			save() {
				var data = new FormData;

				data.append('firstname', this.item.details.firstname);
				data.append('lastname', this.item.details.lastname);
				data.append('middlename', this.item.details.middlename);
				data.append('address', this.item.details.address);
				data.append('birthdate', this.birthdate);
				data.append('contact', this.item.details.contact);
				axios.post(this.updateurl, data)
					.then(response => {
						var data = response.data;
						if(data.response === 'success') {
							swal('Success', 'Information Updated', 'success');
						}
					})
					.catch(errors => {
						swal('Ooops', 'Please fill up all required fields', 'error');
					})
			},

			savechanges() {
				var data = new FormData;

				data.append('old_password', this.item.old_password);
				data.append('password', this.item.password);
				data.append('password_confirmation', this.item.password_confirmation);

				axios.post(this.updatepasswordurl, data)
					.then(response => {
						var data = response.data;
						if(data.response === 1) {
							swal('Success', 'Password Updated', 'success');
						} else if(data.response === 404){
							swal('Oooops', 'Old password is invalid', 'error');
						}
					})
					.catch(error => {
						console.log(error.response.data.errors.password[0]);
						swal('Oooops', error.response.data.errors.password[0], 'error')
					})
			}
		}
	}
</script>