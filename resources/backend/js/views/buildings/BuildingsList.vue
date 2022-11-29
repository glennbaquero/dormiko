<template>
	<div>
		<div class="row">
	        <div class="col-sm-12 col-md-12">
	            <div style="background: transparent;">
	                <div class="box-body">
	                    <div class="media">
	                        <div class="media-body">
	                            <div class="clearfix">
	                                <p class="pull-right" v-if="buildings instanceof Array">
	                                    <a :href="createurl" class="btn-default bg-transparent btn-sm border-0 " style="font-size: 40px;">
	                                        <span class="glyphicon glyphicon-plus-sign"></span>
	                                    </a>
	                                </p>
	                                <div class="form-horizontal" v-if="usertype != 1">
	                                    <div class="box-body">
	                                        <div class="form-group">
	                                            <div class="col-sm-4">
	                                                <input type="text" class="text-box" id="search" placeholder="Search" v-model="search" @keyup="searchBuilding">
	                                                <select class="selection-box" v-model="sort" @change="sortList(sort)" style="width: 70%">
	                                                    <option value='0'>ALPHABETICAL</option>
	                                                    <option value='1'>FLOOR</option>
	                                                </select>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    
	    </div>

	    <div class="row" v-if="buildings instanceof Array">
	        <div class="col-sm-12 col-md-6" v-for="building in searchBuilding">
	            <div class="box box-solid">
	                <div class="box-body">
	                    <div class="media">
	                        <div class="media-left">
	                            <a :href="buildingurl+building.id">
		                            <img v-if="building.images" :src="renderImage(building.images.path)" class="media-object" style="width: 150px;height: auto;box-shadow: 0 1px 3px rgba(0,0,0,.15);">
	                            </a>
	                        </div>
	                        <div class="media-body">
	                            <div class="clearfix">
	                                <p class="pull-right">
	                                    <a :href="editurl+building.id" class="btn btn-default bg-white btn-sm ad-click-event border-0">
											<span class="glyphicon glyphicon-pencil"></span>
	                                    </a>
	                                    <a :href="destroyurl+building.id" class="btn btn-default bg-white btn-sm ad-click-event border-0">
	                                        <span class="glyphicon glyphicon-trash"></span>
	                                    </a>
	                                </p>
	                                <h4 style="margin-top: 0"><b>{{ building.name }}</b></h4>
	                                <p>{{ building.floor }} Floors</p>
	                                <!-- <p>81 Studio Units</p> -->
	                                <!-- <p>244 Beds</p> -->
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
		</div>
		<div class="row" v-else>
			<div class="col-sm-12 col-md-6">
	            <div class="box box-solid">
	                <div class="box-body">
	                    <div class="media">
	                        <div class="media-left">
	                            <a :href="buildingurl+buildings.id">
		                            <img v-if="buildings.images" :src="renderImage(buildings.images.path)" class="media-object" style="width: 150px;height: auto;box-shadow: 0 1px 3px rgba(0,0,0,.15);">
	                            </a>
	                        </div>
	                        <div class="media-body">
	                            <div class="clearfix">
	                                <p class="pull-right">
	                                    <a :href="editurl+buildings.id" class="btn btn-default bg-white btn-sm ad-click-event border-0">
											<span class="glyphicon glyphicon-pencil"></span>
	                                    </a>
	                                    <a :href="destroyurl+buildings.id" class="btn btn-default bg-white btn-sm ad-click-event border-0">
	                                        <span class="glyphicon glyphicon-trash"></span>
	                                    </a>
	                                </p>
	                                <h4 style="margin-top: 0"><b>{{ buildings.name }}</b></h4>
	                                <p>{{ buildings.floor }} Floors</p>
	                                <!-- <p>81 Studio Units</p> -->
	                                <!-- <p>244 Beds</p> -->
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
			createurl: String,
			usertype: Number,
			buildings: Array instanceof Array ? Array : Array
		},

		data() {
			return {
				sort: 0,
				editurl: 'admin/buildings/edit/',
				destroyurl: 'admin/buildings/destroy/',
				buildingurl: 'admin/building/room/',
				search: null,
				buildingDuplicateEntry: this.buildings,
			}
		},

		computed:{
		    searchBuilding() {
		    	let searchTerm = (this.search || "").toLowerCase()
				if(searchTerm) {
					return this.buildings.filter(function(item) {
					    let name = (item.name || "").toLowerCase()
					    return name.indexOf(searchTerm) > -1
					})
				} else {
					return this.buildings;
				}

		    }
		},

		methods:{
			renderImage(image) {
				return 'storage/'+image;
			},

			sortList(type){
				function sort(a, b) {
					if(parseInt(type) === 0){
					    if (a.name < b.name)
					        return -1;
					    if (a.name > b.name)
					        return 1;
					} else {
						if (a.floor < b.floor)
					        return -1;
					    if (a.floor > b.floor)
					        return 1;
					}
					return 0;
				}

			    return this.buildings.sort(sort);
		    },
		}
	}
</script>