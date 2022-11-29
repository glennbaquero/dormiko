<template>
	<div>
		<div :class="showPenalty" id="modal-penalty-rent" :style="'display:'+ display">
	        <div class="modal-dialog penalty-modal-top-border">
	            <div class="modal-content">
	              	<div class="modal-body">
	               	 	<div class="form-group">
	               	 		<i class="c-red">Payment Overdue</i>
	               	 		<p>Tenant ID</p>
	               	 		<input type="text" class="penalty-text-input"  disabled v-model="data.item.tenant_id">
	               	 		<p>Tenant Name</p>
	               	 		<input type="text" class="penalty-text-input" disabled v-model="data.item.name">
	               	 		<p>Penalty Amount</p>
	               	 		<input type="number" class="penalty-text-input" name="penalty" v-model="data.item.penalty">
	               	 		<p>Description</p>
	               	 		<input type="text" class="penalty-text-input" name="description" v-model="data.item.description">
	               	 	</div>
	               	 	<div class="text-center">
		                	<button type="button" class="btn btn-primary modal-btn-primary" @click="penalty">Add</button>
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
	export default {
		data() {
			return {
				showPenalty: 'modal fade',
				display: 'none',
				data: {
					item: {
						tenant_id: null,
						name: null,
						penalty: 0,
						description: null
					}
				},
				url: null
			}
		},

		components: {

		},

		mounted() {
			EventBus.$on('rent-penalty-modal', item => {
				 	this.showPenalty = 'modal fade in';
				 	this.display = 'block';
				 	this.data = item;
				 	this.url = item.penaltyurl
				 });
		},

		methods: {
			close() {
				this.showPenalty = 'modal fade';
				this.display = 'none';
			},

			penalty() {
				var data = new FormData();
				data.append('penalty', this.data.item.penalty);
				axios.post(this.url, data)
					.then(response => {
						swal('Penalty Added!', 'Adding penalty is succesfully added to '+ this.data.item.name, 'success');
					})
			}

		}
	}
</script>