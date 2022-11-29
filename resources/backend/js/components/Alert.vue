<template>
	<div>
		<!-- <div :id="id" class="modal modal-danger fade in" :class="'modal-' + bgType"> -->
		<div :class="showModalType" :id="id" :style="'display:'+ display">	
			<div class="modal-dialog">
	            <div class="modal-content">
	              	<div class="modal-body">
	              		<div class="text-center">
	               	 		<img src="storage/splices/success.png" width="20%">
	               	 		<ul v-show="typeof errors === 'object'">
					
								<template v-for="error in errors">
									<li v-for="message in error">{{ message }}</li>
								</template>
							</ul>
							<p v-show="typeof errors === 'string'">{{ errors }}</p>

							<ul v-show="list && list.length > 0">
								<li v-for="item in list">{{ item }}</li>
							</ul>
		               	 	<button type="button" class="btn btn-success modal-btn-primary" data-dismiss="modal" @click="close">Ok</button>
		               	</div>
	              	</div>
	            </div>
	        </div>
			<!-- <div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" data-backdrop="false">
						<span aria-hidden="true">×</span>
					</button>
					<h5 class="modal-title">
						<i class="fa" :class="type"></i>
						{{ title }}
					</h5>
				</div>
				<div class="modal-body">
					<ul v-show="typeof errors === 'object'">
					
						<template v-for="error in errors">
							<li v-for="message in error">{{ message }}</li>
						</template>
					</ul>
					<p v-show="typeof errors === 'string'">{{ errors }}</p>

					<ul v-show="list && list.length > 0">
						<li v-for="item in list">{{ item }}</li>
					</ul>
				</div> -->
				<!-- <div class="modal-footer">
					<button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
				</div> -->
			<!-- </div> -->
			<!-- /.modal-content -->
			<!-- </div> -->
		<!-- /.modal-dialog -->
		</div>
	</div>
</template>

<script type="text/javascript">

	import { EventBus } from '../EventBus.js';

	export default {
		props: {
			id: {
				default: 'alertModal',
			}
		},

		data() {
			return {
				title: null,
				type: 'info-circle',
				bgType: 'bg-default',
				showModalType: 'modal fade',
				display: 'none',

				list: [],

				errors: [],

				hasErrors: false,
			}
		},

		mounted() {
			EventBus.$on('showModal', (data) => {
				this.setup(data);
				this.showModalType = 'modal fade in';
			 	this.display = 'block';
			});
		},

		methods: {

			setup(data) {
				this.title = data.title ? data.title : 'Alert Message';
				this.list = data.list ? data.list : [];
				this.errors = data.content ? data.content : 'Please try again later.';
				this.hasErrors = data.hasErrors;
				this.redirectUrl = data.redirectUrl;

				switch (data.type) {
					case 'success': case 1: case true:
							this.type = 'fa-check';
							this.bgType = 'primary text-white';
						break;
					case 'danger': case 0: case false: case 'error':
							this.type = 'fa-warning';
							this.bgType = 'danger text-white';
						break;
					default:
							this.type = 'fa-info-circle';
							this.bgType = 'default text-dark';
						break;
				}

				if (typeof data.content === 'object') {
					this.type = 'fa-warning';
					this.hasErrors = true;
				}

				this.show();
			},

			show(errors) {
				$('#' + this.id).modal('show');

				$('#' + this.id).on('hidden.bs.modal', () => {

					if (this.redirectUrl) {
						window.location.href = this.redirectUrl;
					}
				    
				});
			},

			close() {
				this.showModalType = 'modal fade';
				this.display = 'none';
				$('.modal-backdrop').remove();
				$(document.body).css('overflow', 'scroll');
				$(document.body).css('padding-right', '0px');
			},

		},
	}
</script>