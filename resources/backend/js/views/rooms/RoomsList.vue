<template>
	<div>
		<div class="row">
            <div class="col-sm-12 col-md-12">
                <div style="background: transparent;">
                    <div class="box-body">
                        <div class="media">
                            <div class="media-body">
                                <div class="clearfix">
                                    <p class="pull-right">
                                        <a :href="createurl+'?floor='+floor" class="btn-default bg-transparent btn-sm border-0 " style="font-size: 40px;">
                                            <span class="glyphicon glyphicon-plus-sign"></span>
                                        </a>
                                    </p>
                                    <div class="form-horizontal">
                                        <div class="box-body">
                                                <input type="text" class="text-box w-25" id="search" placeholder="Search" v-model="search">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <select class="selection-box w-15" @change="floorChange(floor)" v-model="floor">
                                                        <option v-for="n in building.floor" :value="n">{{ n }} Floor</option>
                                                    </select>
                                                    <select class="selection-box w-15" v-model="type">
                                                        <option selected disabled>Type</option>
                                                        <option value="0">Apartment</option>
                                                        <option value="1">Dorm</option>
                                                        <option value="2">Studio</option>
                                                    </select>
                                                    <select class="selection-box w-15" v-model="gender">
                                                        <option value="0">Male</option>
                                                        <option value="1">Female</option>
                                                        <option value="2">Mix</option>
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

        <div class="row">
	        <div class="col-sm-12 col-md-4" v-for="room in floorChange()">
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="media">
                            <div class="media-left">
                                <a :href="roomdetail+room.id">
                                    <img :src="renderImage(room.image)" class="media-object" style="width: 150px;height: auto;box-shadow: 0 1px 3px rgba(0,0,0,.15);">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="clearfix">
                                    <p class="pull-right">
                                        <a :href="editurl+room.id+'?floor='+floor" class="btn btn-default bg-white btn-sm ad-click-event border-0">
											<span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                        <a :href="destroyurl+room.id" class="btn btn-default bg-white btn-sm ad-click-event border-0">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                    </p>
                                    <h4 style="margin-top: 0"><b>{{ room.unit_name }}</b></h4>
                                    <p>{{ room.room_type === 0 ? 'APARTMENT' : (room.room_type === 1 ? 'DORM' : 'STUDIO') }}</p>
                                    <p>{{ room.status === 0 ? 'Occupied' : 'Available' }}</p>
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
            id: Number,
			createurl: String,
            building: Object,
            buildings: Array
		},

        data(){
            return {
                editurl: '/admin/room/edit/',
                destroyurl: '/admin/room/destroy/',
                roomdetail: '/admin/tenants?room=',
                floor: 1,
                type: 0,
                gender: 0,
                floorSize: null,
                floorUnit: null,
                search: null
            }
        },

        mounted() {
            this.getMaxFloorInBuilding();
            window.history.pushState("", "", '/admin/building/room/'+this.building.id+'?floor='+this.floor);
        },

        methods: {

            getMaxFloorInBuilding() {
                this.floor = 1;
                var max = this.building.rooms.reduce(function (prev, current) {
                   return (prev.floor > current.floor) ? prev : current
                });
                this.floorUnit = this.building.rooms;
                this.floorSize = max;
            },

            renderImage(image) {
                return 'storage/'+image;
            },

            floorChange() {
                window.history.pushState("", "", '/admin/building/room/'+this.building.id+'?floor='+this.floor);
                let filtered = this.building.rooms;

                if(this.search) {
                    filtered = filtered.filter(
                        m => m.unit_name === this.search
                    );
                }

                if(this.floor) {
                    filtered = filtered.filter(
                        m => m.floor === this.floor
                    );
                }

                if(this.type) {
                    filtered = filtered.filter(
                        m => m.room_type === parseInt(this.type)
                    );
                }

                if(this.gender) {
                    filtered = filtered.filter(
                        m => m.prefer_tenant_gender === parseInt(this.gender)
                    );
                }
                
                return filtered;
            },
       }
	}
</script>