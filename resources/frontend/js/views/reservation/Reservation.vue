<template>
	<div>
		<loading
		:display="display">
		</loading>
		<div class="form__row">
			<div class="form__input half__width">
				<h6 class="font-xs xs-padding-b">First Name *</h6>
				<input type="text" :class="errors.firstname ? 'error' : ''" name="firstname" v-model="item.firstname">
				<label class="error" v-show="errors.firstname">This field is required.</label>
			</div
			><div class="form__input half__width">
				<h6 class="font-xs xs-padding-b">Last Name *</h6>
				<input type="text" :class="errors.lastname ? 'error' : ''" name="lastname" v-model="item.lastname">
				<label class="error" v-show="errors.lastname">This field is required.</label>
			</div>
		</div>
		<div class="form__row">
			<div class="form__input half__width">
				<h6 class="font-xs xs-padding-b">Gender *</h6>
				<select name="gender" :class="errors.gender ? 'error' : ''" v-model="item.gender">
					<option hidden></option>
					<option value="1">Male</option>
					<option value="2">Female</option>
				</select>
				<label class="error" v-show="errors.gender">This field is required.</label>
			</div
			><div class="form__input half__width">
				<h6 class="font-xs xs-padding-b">Contact Number *</h6>
				<input type="number" :class="errors.contact ? 'error' : ''" class="contact_no" name="contact" v-model="item.contact">
				<label class="error" v-show="errors.contact">This field is required.</label>
			</div>
		</div>
		<div class="form__row">
			<div class="form__input">
				<h6 class="font-xs xs-padding-b">Email *</h6>
				<input type="email" :class="errors.email ? 'error' : ''" name="email" v-model="item.email">
				<label class="error" v-show="errors.email">This field is required.</label>
			</div>
		</div>
		<div class="form__row">
			<div class="form__input">
				<h6 class="font-xs xs-padding-b">Company *</h6>
				<input type="text" :class="errors.company ? 'error' : ''" name="company" v-model="item.company">
				<label class="error" v-show="errors.company">This field is required.</label>
			</div>
		</div>
		<div class="form__row">
			<div class="form__input">
				<h6 class="font-xs xs-padding-b">Workplace Location *</h6>
				<input type="text" :class="errors.workplace ? 'error' : ''" name="workplace" v-model="item.workplace">
				<label class="error" v-show="errors.workplace">This field is required.</label>
			</div>
		</div>
		<div class="form__row">
			<div class="form__input">
				<h6 class="font-xs xs-padding-b">Montly Earning *</h6>
				<!-- <input type="number" :class="errors.monthly_earning ? 'error' : ''" name="monthly_earning" v-model="item.monthly_earning"> -->
				<span class="input-peso left">
				    <input type="number" :class="errors.monthly_earning ? 'error' : ''" name="monthly_earning" v-model="item.monthly_earning" style="display: inline-block;">
				<label class="error" v-show="errors.monthly_earning">This field is required.</label>
				</span>
			</div>
		</div>
		<div class="form__row">
			<div class="form__input">
				<h6 class="font-xs xs-padding-b">Move In *</h6>
				<input type="date" :class="errors.movein ? 'error' : ''" name="movein" v-model="item.movein" :min="date_today">
				<label class="error" v-show="errors.movein">This field is required.</label>
			</div>
		</div>
		<div class="form__row">
			<div class="form__input">
				<!-- <h6 class="font-xs xs-padding-b">Move Out</h6>
				<input type="date" name="moveout" v-model="item.moveout" :disabled="disable" :min="date_today" required> -->
			</div
			><div class="form__input half__width">
				<!-- <h6 class="font-xs xs-padding-b">Overnight Stay</h6>
				<select name="overnight" v-model="item.overnight" @change="overnight(item.overnight)">
					<option hidden></option>
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select> -->
			</div>
		</div>
		<div class="form__row">
			<div class="form__input">
				<h6 class="font-xs xs-padding-b">Message</h6>
				<textarea name="message" rows="7" v-model="item.message"></textarea>
			</div>
		</div>
		<div class="form__row">
			<div class="form__input">
				<h6 class="font-xs xs-padding-b">Upload credentials (atleast 2)</h6>
				<input type="file" name="credentials" multiple id="files" ref="files" @change="credentials">
				<!-- <label class="error" v-show="errors.images">This field is required.</label> -->
			</div>
		</div>
		<button class="btn btn--orange" @click="reserve()">Reserve Now</button>
	</div>
</template>
<script>

	import Loading from '../includes/Loading.vue';

	export default {
		props: {
			roomtype: Number,
			building: Number,
			reservationurl: String,
			date_today: String
		},

		components: {
			'loading': Loading
		},

		data() {
			return {
				item: {
					overnight: 0,
					firstname: null,
					lastname: null,
					gender: null,
					email: null,
					company: null,
					contact: null,
					monthly_earning: null,
					movein: null,
					workplace: null,
					message: null,
					images: null,
					building_id: this.building,
					room_type: this.roomtype
				},

				errors: {
					firstname: false,
					lastname: false,
					email: false,
					gender: false,
					company: false,
					contact: false,
					monthly_earning: false,
					movein: false,
					workplace: false,
					images: false,
				},

				error: null,

				display: 'none',

				disable: false
			}
		},

		methods:{
			overnight(disable) {
				if(disable == 1) {
					this.disable = true;
				} else {
					this.disable = false;
				}
			},

			credentials(e) {
				this.item.images = this.$refs.files.files;
	        },

			reserve() {

				// this.validate();
				this.display = 'block';

				var data = new FormData();
				if(this.item.images) {
					for( var i = 0; i < this.item.images.length; i++ ){
						let file = this.item.images[i];

						data.append('path[' + i + ']', file);
					}
				}

				data.append('firstname', this.item.firstname);
				data.append('lastname', this.item.lastname);
				data.append('gender', this.item.gender);
				data.append('email', this.item.email);
				data.append('message', this.item.message);
				data.append('company', this.item.company);
				data.append('contact', this.item.contact);
				data.append('monthly_earning', this.item.monthly_earning);
				data.append('movein', this.item.movein);
				data.append('moveout', this.item.moveout);
				data.append('overnight', this.item.overnight);
				data.append('workplace', this.item.workplace);
				data.append('room_type', this.item.room_type);
				data.append('building_id', this.item.building_id);
				
				if(this.item.firstname != null && this.item.lastname != null && this.item.gender != null && this.item.email != null && this.item.company != null && this.item.contact != null && this.item.monthly_earning != null && this.item.movein != null && this.item.workplace != null) {
					if(!this.validEmail(this.item.email)) {
						swal('Oooops!', 'Invalid Email', 'error');
						this.display = 'none';
					} else {
						axios.post(this.reservationurl, data, { headers: { 'Content-Type': 'multipart/form-data' } })
							.then(response => {
								if(response.data.message === 'success') {
									this.display = 'none';
									swal('Reservation successful!', 'Thank you for reservation. To proceed we will send you a link once your application is approved.', 'success');							
								} else if(response.data.message === 'Email is already used!') {
									this.display = 'none';
									swal('Reservation Failed!', 'Email is already used!', 'error');		
								}
							})
							.catch(errors => {
								this.display = 'none';
								swal('Ooops!', 'Error occured!.', 'error');		
							});
					}
				} else {
					this.display = 'none';
					swal('Reservation Failed!', 'Please fill up the required details!.', 'error');	
				}

				
			},

			validEmail: function (email) {
		      	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		      	return re.test(email);
		    },

			validate() {
				var item = this.item,
					error = this.errors;

				if(item.firstname == null) {
					error.firstname = true;
				} else {
					error.firstname = false;
				}

				if(item.lastname == null) {
					error.lastname = true;
				} else {
					error.lastname = false;
				}

				if(item.email == null) {
					error.email = true;
				} else {
					error.email = false;
				}

				if(item.company == null) {
					error.company = true;
				} else {
					error.company = false;
				}

				if(item.contact == null) {
					error.contact = true;
				} else {
					error.contact = false;
				}

				if(item.monthly_earning == null) {
					error.monthly_earning = true;
				} else {
					error.monthly_earning = false;
				}

				if(item.movein == null) {
					error.movein = true;
				} else {
					error.movein = false;
				}

				if(item.workplace == null) {
					error.workplace = true;
				} else {
					error.workplace = false;
				}

				if(item.gender == null) {
					error.gender = true;
				} else {
					error.gender = false;
				}

				if(item.images == null) {
					error.images = true;
				} else {
					error.images = false;
				}

			}
		}
	}
</script>