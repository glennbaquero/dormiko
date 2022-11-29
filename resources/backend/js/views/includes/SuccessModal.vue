<template>
	<div>
		<div :class="showModalType" id="modal-utility-type" :style="'display:'+ display">
	        <div class="modal-dialog" style="margin: 20% auto; width: 20%">
	            <div class="modal-content">
	              	<div class="modal-body">
	               	 	<div class="text-center">
	               	 		<img src="storage/splices/success.png" width="20%">
	               	 		<p>Success!</p>
		               	 	<button type="button" class="btn btn-success modal-btn-primary" data-dismiss="modal" @click="close">Ok</button>
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

		data(){
			return {
				showModalType: 'modal fade',
				display: 'none'
			}
		},

		mounted() {
			EventBus.$on('success-modal', data => {
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
		}
	}
</script>