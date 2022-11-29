<template>
	<div>
		<div :class="showModalType" id="modal-utility-type" :style="'display:'+ display">
	        <div class="modal-dialog" style="border-top: #0f0f2d solid 5px; margin-top: 9%; width: 30%">
	            <div class="modal-content">
	              	<div class="modal-body">
	               	 	<div class="form-group">
	               	 		<p>Utility Type</p>
	               	 		<input type="text" name="name" class="form-control" v-model="item.name" style="border: 1px solid #000; border-radius: 0px">

	               	 		<p>Utility Fee</p>
	               	 		<input type="text" name="fee" class="form-control" v-model="item.fee" style="border: 1px solid #000; border-radius: 0px">

	               	 		<p>Description</p>
	               	 		<input type="text" name="description" class="form-control" v-model="item.description" style="border: 1px solid #000; border-radius: 0px">
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
			show: Boolean,
			url: String,
		}, 

		data(){
			return {
				item:{},
				showModalType: 'modal fade',
				display: 'none'
			}
		},

		mounted() {
			EventBus.$on('utility-type-modal', data => {
				 	this.showModalType = 'modal fade in';
				 	this.display = 'block';
				 });
		},

		methods: {
			close() {
				this.showModalType = 'modal fade';
				this.display = 'none';
				$('.modal-backdrop').remove();
			},

			submit() {
				var data = {
					'description': this.item.description,
					'fee': this.item.fee,
					'name': this.item.name
				};

				axios.post(this.url, data)
					.then(response => {
						this.show = false;
						console.log(response.data.message);
						swal('Utility Added', 'Successfully added a new utility type!', 'success');
					})
					.catch(error => {
						if(error.response.data.errors.fee) {
							swal('Oooops', error.response.data.errors.fee[0], 'error')
						} else {
							swal('Oooops', error.response.data.errors.name[0], 'error')
						}
					})
			}
		}
	}
</script>