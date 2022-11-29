<template>
	<div>
		<div class="col-md-12" v-show="show">
			<button class="btn btn-default btn-flat pull-right" style="background: transparent; border:none; margin-right: 43px"  @click="exportdata()"><img src="splices/Icons/Web App/export.svg">Export</button>
			<button class="btn btn-default btn-flat pull-right" style="background: transparent; border:none" data-toggle="modal" data-target="#modal-utility-fee" @click="showUtilityFee"><img src="splices/Icons/Web App/add.svg" width="30px">Add Utility Fee</button> 
			<button class="btn btn-default btn-flat pull-right" style="background: transparent; border:none" data-toggle="modal" data-target="#modal-utility-type"  @click="showUtilityButton" ><img src="splices/Icons/Web App/add.svg" width="30px">Add Type</button>
		</div>
		<div class="col-md-12" v-show="!show">
			<button class="btn btn-default btn-flat pull-right" style="background: transparent; border:none; margin-right: 43px"  @click="exportdata()"><img src="splices/Icons/Web App/export.svg">Export</button> 
		</div>
		<br><br><br>
		<div class="col-xs-12">
			<div class="box box-widget nav-tabs-custom">
				<ul class="nav nav-tabs">
		            <li class="active">
		                <a href="#pages" data-toggle="tab" @click="showTable(false, 1)"><h5><b>Rent</b></h5></a>
		            </li>
		            <li>
		                <a href="#page-utils" data-toggle="tab" @click="showTable(true, 2)"><h5><b>Utility</b></h5></a>
		            </li>
		            <li>
		                <a href="#page-history" data-toggle="tab" @click="showTable(false, 3)"><h5><b>History</b></h5></a>
		            </li>
		        </ul>
	        </div>

		    <add-utility-type 
		    	:url="posturlutility"></add-utility-type>
		    <add-utility-fee
		    :contracts="fetchcontracts"
		    :utilities="fetchutilities"
		    :url="posturlutilityfee"></add-utility-fee>
	    </div>
	</div>
</template>
<script>
	import {EventBus} from '../../EventBus.js';
	import AddUtilityType from './AddUtilityType.vue';
	import AddUtilityFee from './AddUtilityFee.vue'
	export default{
		props: {
			posturlutility: String,
			posturlutilityfee: String,
			billingrentexport: String,
			billingutilityexport: String,
			fetchcontracts: Array,
			fetchutilities: Array,
		},

		data() {
			return{
				show: false,
				modalShow: false,
				exportData: 1,
			}
		},

		components: {
			'add-utility-type' : AddUtilityType,
			'add-utility-fee' : AddUtilityFee,
		},

		methods : {
			showUtilityButton() {
				EventBus.$emit('utility-type-modal');
			},
			showUtilityFee() {
				EventBus.$emit('utility-fee-modal');
			},

			showTable(show, exportData) {
				this.show = show;
				this.exportData = exportData;
			},

			exportdata() {
				if(this.exportData === 1) {
					window.location.href = this.billingrentexport;
				} 

				if(this.exportData === 2) {
					window.location.href = this.billingutilityexport;
				}
			}
		}
	}
</script>