<template>
	<div>
		<div class="col-md-8" >
			<label style="font-size: 23px">Personal Information</label>
			<div class="row">
				<div class="form-group col-md-4">
					<label>Firstname</label>
					<input name="firstname" type="text" class="form-control input-sm" v-model="item.user.user_detail.firstname">
				</div>
				<div class="form-group col-md-4">
					<label>Lastname</label>
					<input name="lastname" type="text" class="form-control input-sm" v-model="item.user.user_detail.lastname">
				</div>
				<div class="form-group col-md-4">
					<label>Middlename</label>
					<input name="middlename" type="text" class="form-control input-sm" v-model="item.user.user_detail.middlename">
				</div>
				<div class="form-group col-md-4">
					<label for="">Birth Date</label>
					<div class="input-group date">
	                  	<div class="input-group-addon">
	                    	<i class="fa fa-calendar"></i>
	                  	</div>
	                  	<input type="text" class="form-control pull-right" name="birthdate" id="datepicker" v-model="item.user.user_detail.birthdate">
	                </div>
				</div>
				<div class="form-group col-md-4">
					<label>Contact Number</label>
					<input name="contact" type="text" class="form-control input-sm" v-model="item.user.user_detail.contact">
				</div>
				<div class="form-group col-md-12">
					<label>Address</label>
					<input name="address" type="text" class="form-control input-sm" v-model="item.user.user_detail.address">
				</div>
				<div class="form-group col-md-12">
					<button type="submit" class="btn btn-primary pull-left" style="margin-right: 5px">Update Info</button>
				</div>
			</div>
        </div>
	</div>
</template>
<script>
	export default{
		props: {
			item: Object
		}
	}
</script>