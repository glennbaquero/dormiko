<template>
	<div>
		<div class="col-sm-12">
			<input type="text" class="text-box w-25" id="search" placeholder="Search" v-model="search" @keyup="searchAdmin">
		</div>
		<div class="col-sm-12 col-md-6" v-for="admin in adminDuplicate" v-if="admin.id !== auth.id">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="media">
                        <div class="media-left">
                            <img  src="https://via.placeholder.com/300" class="media-object" style="width: 150px;height: auto;box-shadow: 0 1px 3px rgba(0,0,0,.15);">
                        </div>
                        <div class="media-body">
                            <div class="clearfix">
                                <p class="pull-right">
                                    <a :href="url+admin.id" class="btn btn-default bg-white btn-sm ad-click-event border-0">
										<span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    <a :href="destroyurl+admin.id" class="btn btn-default bg-white btn-sm ad-click-event border-0">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </p>
                                <h4 style="margin-top: 0"><b>{{ admin.firstname }} {{ admin.lastname }}</b></h4>
                                <p style="margin: 0 0 2px">{{ admin.email }}</p>
                                <p style="margin: 0 0 2px">{{ admin.contact }}</p>
                                <p style="margin: 0 0 2px; text-overflow: ellipsis; width: 20em;">{{ admin.address }}</p>
                                <p style="margin: 0 0 2px">{{ admin.status === 1 ? 'Active' : 'Inactive' }}</p>
                                <!-- <p>81 Studio Units</p> -->
                                <!-- <p>244 Beds</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</template>
<script>
	export default {
		props: {
			admins: Array instanceof Array ? Array : Array,
			auth: Object
		},

		data() {
			return {
				adminDuplicate: this.admins,
				search: null,
				url: 'admin/permission/edit/',
				destroyurl: 'admin/permission/destroy/'
			}
		},

		methods: {
			searchAdmin() {
				let filtered = this.admins;
				console.log(filtered);
		    	if(this.search) {
		    		filtered = this.admins.filter(
			          	m => m.firstname.toLowerCase().indexOf(this.search) > -1 || m.lastname.toLowerCase().indexOf(this.search) > -1 ||
			          		m.email.toLowerCase().indexOf(this.search) > -1
			        );
			        
			        return this.adminDuplicate = filtered;
			    } else {
			    	this.adminDuplicate = this.admins;
			    }
			}
		}
	}
</script>