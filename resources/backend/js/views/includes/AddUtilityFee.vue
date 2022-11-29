<template>
	<div>
		<div :class="showModalFee" id="modal-utility-fee" :style="'display:'+ display">
	        <div class="modal-dialog" style="border-top: #0f0f2d solid 5px; margin-top: 7%; width: 30%">
	            <div class="modal-content">
	              	<div class="modal-body">
	               	 	<div class="form-group">
	               	 		<p>Tenant Name</p>
							<select class="form-control" v-model="item.contract_id" style="border: 1px solid #000; border-radius: 0px">
								<option v-for="contract in contracts" :value="contract.id">{{ contract.user.user_detail.firstname }} {{ contract.user.user_detail.lastname }}</option>
							</select>

							<p>Utility Type</p>
	               	 		<select class="form-control" v-model="item.utility_id" style="border: 1px solid #000; border-radius: 0px">
								<option v-for="utility in utilities" :value="utility.id">{{ utility.name }}</option>
							</select>

							<p>Duration Start</p>
							<input type="date" name="duration_start" class="form-control" v-model="item.duration_start" style="border: 1px solid #000; border-radius: 0px">

							<p>Duration End</p>
							<input type="date" name="duration_end" class="form-control" v-model="item.duration_end" style="border: 1px solid #000; border-radius: 0px">

							<p>Due Date</p>
							<input type="date" name="due_date" class="form-control" v-model="item.due_date" style="border: 1px solid #000; border-radius: 0px">

							<p>Amount</p>
							<input type="number" name="amount" class="form-control" v-model="item.amount" style="border: 1px solid #000; border-radius: 0px">
	               	 	</div>
	               	 	<div class="text-center">
		                	<button type="button" class="btn btn-primary modal-btn-primary" @click="submit">Save</button>
		               	 	<button type="button" class="btn btn-default modal-btn-primary" data-dismiss="modal" @click="close">Cancel</button>
		               	</div>
	              	</div>
	            </div>
	        </div>
	    </div>
    </div>

</template>
<script>
	import {EventBus} from '../../EventBus.js';
	export default{
		props: {
			url: String,
			contracts: Array,
			utilities: Array
		}, 

		data(){
			return {
				item:{},
				showModalFee: 'modal fade',
				display: 'none'
			}
		},

		mounted() {
			EventBus.$on('utility-fee-modal', data => {
				 	this.showModalFee = 'modal fade in';
				 	this.display = 'block';
				 });
		},

		methods: {
			close() {
				this.showModalFee = 'modal fade';
				this.display = 'none';
				$('.modal-backdrop').remove();
			},

			submit() {
				var data = {
					'contract_id': this.item.contract_id,
					'duration_end': this.item.duration_end,
					'due_date': this.item.due_date,
					'utility_id': this.item.utility_id,
					'amount': this.item.amount,
					'duration_start': this.item.duration_start
				};

				axios.post(this.url, data)
					.then(response => {
						this.show = false;
						console.log(response.data.message);
						swal('Utility Fee', 'Successfully added utility fee to the tenant!', 'success');
					})
					.catch(error => {
						if(error.response.data.errors.duration_start) {
							swal('Oooops', error.response.data.errors.duration_start[0], 'error')
						} else if(error.response.data.errors.duration_end) {
							swal('Oooops', error.response.data.errors.duration_end[0], 'error')
						} else if(error.response.data.errors.due_date) {
							swal('Oooops', error.response.data.errors.due_date[0], 'error')
						} else if(error.response.data.errors.utility_id) {
							swal('Oooops', error.response.data.errors.utility_id[0], 'error')
						} else if(error.response.data.errors.amount) {
							swal('Oooops', error.response.data.errors.amount[0], 'error')
						} else {
							swal('Oooops', 'Please select tenant', 'error')
						}
					})
			}
		}
	}
</script>