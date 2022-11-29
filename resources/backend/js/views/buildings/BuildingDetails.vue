<template>
	<div>
        <!-- Start Box Body -->
        <!-- <div class="box-body"> -->
            <!-- Start Row -->
            <!-- <div class="row"> -->
        		<loader
                :loading="loading"
                ></loader>
                	<div class="col col-xs-12 col-sm-12 col-md-4">
                		<div class="form-group">
                			<label for="">Name</label>
                			<input name="name" type="text" class="form-control input-sm" placeholder="Name" v-model="item.name">
                		</div>
                		<div class="form-group">
                			<label for="">Floors</label>
                			<input name="floor" type="number" class="form-control input-sm" min=1 placeholder="0" v-model="item.floor">
                		</div>
                		<div class="form-group">
                            <label for="">Image</label> <a v-if="item.images" :href="viewImage(item.images.path)" target="_blank">View</a>
                            <input name="path" type="file" class="form-control input-sm" placeholder="Image" @change="buildingImage">
                        </div>
                        <!-- <img id="img" width="75px" height="75px" :hidden="hidden"> -->
                	</div>
                    <div class="col col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="">Building Location
                                <position-finder 
                                :address="item.location"
                                @onfetch="positionFetch"
                                :fetchurl="fetchpositionurl">
                                </position-finder>
                            </label>
                            <input name="location" type="text" class="form-control input-sm" v-model="item.location">
                        </div>
                        <div class="form-group">
                            <label for="">Latitude</label>
                            <input name="latitude" type="text" class="form-control input-sm" v-model="item.latitude">
                        </div>
                        <div class="form-group">
                            <label for="">Longitude</label>
                            <input name="longitude" type="text" class="form-control input-sm" v-model="item.longitude">
                        </div>
                    </div>

                    <div class="col col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="">Availability</label>
                            <select name="availability" class="form-control input-sm" v-model="item.availability">
                                <option value="1">Available</option>
                                <option value="0">Coming Soon</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="">Waze Link</label>
                            <input name="waze_link" type="text" class="form-control input-sm" placeholder="Waze Link" v-model="item.waze_link">
                        </div>
                    </div>

                    <!-- <div class="col col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="">Google Map Link</label>
                            <input name="google_map_link" type="text" class="form-control input-sm" placeholder="Google Map Link" v-model="item.google_map_link">
                        </div>
                    </div> -->
                    
                    <div class="col col-xs-12 col-md-12 col-md-6">
                        <label>Building Banner</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image Position</th>
                                        <th>Image</th>
                                        <th v-if="item.banners.length > 0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>First Row Image <small>(Right > Upper > Left)</small></td>
                                        <td>
                                            <input type="file" name="banner_image[]">
                                            <input v-if="item.banners.length >= 1" type="hidden" :value="item.banners[0].id" name="banner_id[]">
                                        </td>
                                        <td v-if="item.banners.length >= 1">
                                            <a :href="viewImage(item.banners[0].image)" target="_blank" >View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>First Row Image <small>(Right > Upper > Right)</small></td>
                                        <td>
                                            <input type="file" name="banner_image[]">
                                            <input v-if="item.banners.length >= 2" type="hidden" :value="item.banners[1].id" name="banner_id[]">
                                        </td>
                                        <td v-if="item.banners.length >= 2">
                                            <a :href="viewImage(item.banners[1].image)" target="_blank">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Second Row Image <small>(Right)</small></td>
                                        <td>
                                            <input type="file" name="banner_image[]">
                                            <input v-if="item.banners.length >= 3" type="hidden" :value="item.banners[2].id" name="banner_id[]">
                                        </td>
                                        <td v-if="item.banners.length >= 3">
                                            <a :href="viewImage(item.banners[2].image)" target="_blank">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Center Image</td>
                                        <td>
                                            <input type="file" name="banner_image[]">
                                            <input v-if="item.banners.length >= 4" type="hidden" :value="item.banners[3].id" name="banner_id[]">
                                        </td>
                                        <td v-if="item.banners.length >= 4">
                                            <a :href="viewImage(item.banners[3].image)" target="_blank">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Left Image > Upper</td>
                                        <td>
                                            <input type="file" name="banner_image[]">
                                            <input v-if="item.banners.length >= 5" type="hidden" :value="item.banners[4].id" name="banner_id[]">
                                        </td>
                                        <td v-if="item.banners.length >= 5">
                                            <a :href="viewImage(item.banners[4].image)" target="_blank">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Left Image > Bottom</td>
                                        <td>
                                            <input type="file" name="banner_image[]">
                                            <input v-if="item.banners.length >= 6" type="hidden" :value="item.banners[5].id" name="banner_id[]">
                                        </td>
                                        <td v-if="item.banners.length >= 6">
                                            <a :href="viewImage(item.banners[5].image)" target="_blank">View</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col col-xs-12 col-md-12 col-md-6">
                        <label>Unit Image</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Unit Type</th>
                                        <th>Image</th>
                                        <td v-if="item.dormitory_image != null || item.studio_image != null">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dormitory</td>
                                        <td>
                                            <input type="file" name="dormitory_image">
                                        </td>
                                        <td v-if="item.dormitory_image != null">
                                            <a :href="viewImage(item.dormitory_image)" target="_blank">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Studio</td>
                                        <td>
                                            <input type="file" name="studio_image">
                                        </td>
                                        <td v-if="item.studio_image != null">
                                            <a :href="viewImage(item.studio_image)" target="_blank">View</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <list-field
                            @sendData="handleData"
                            :label="'Amenities'"
                            :placeholder="'Name'"
                            :name="'amenity_name[]'"
                            :disabled="editable"
                            :list="item.amenity">
                            </list-field>
                        </div>
                    </div>

                    <div class="col col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="content">{{ item.description }}</textarea>
                        </div>
                    </div>
                    

                    

                <success-modal-prompt></success-modal-prompt>
            <!-- </div> -->
            <!-- <button type="submit" class="btn btn-primary pull-left" @click="save">Submit</button> -->
        <!-- </div> -->
    </div>
</template>
<script>
import Loader from '../../components/Loader.vue';
import flatpickr from '../../mixins/flatpickr.js';
import select2 from '../../mixins/select2.js';
import ckeditor from '../../mixins/ckeditor.js';
import PositionFinder from '../../components/PositionFinder.vue';
import ListField from '../../components/ListField.vue';
import SuccessModal from '../includes/SuccessModal.vue';
import {EventBus} from '../../EventBus.js';

export default {
	props: {
        submiturl: String,
        fetchurl: String,
        disabled: Boolean,
        building: Object,
        model: {},
        fetchpositionurl: String
    },

    components: {
        'loader': Loader,
        'list-field': ListField,
        'position-finder': PositionFinder,
        'success-modal-prompt' : SuccessModal
    },

    mixins: [
        ckeditor,
        flatpickr,
        select2,
    ],

    data() {
        return {
            loading: false,
            item: {
                banners:{},
                latitude: 0,
                longitude: 0,
                availability: 1,
                dormitory_image: null,
                studio_image: null,
            },
            hidden: true,
    	}
    },

    computed: {
    	editable() {
    		return this.disabled;
    	},
    },

    mounted() {
    	this.setup();
    	this.init();
    },

    methods: {
        showMessage() {
            EventBus.$emit('success-modal');
        },

    	setup() {
    		if (this.model) {
    			this.item = this.model ? this.model : {};
    		}
            this.$nextTick(() => {
                this.ckeditor.init();
            });
    	},

    	init() {
    		this.fetch();
    	},

    	fetch() {
            this.building ? this.item = this.building : this.item;
    	},

        handleData(data) {
            console.log(data);
        },

        save() {
            var data = new FormData();

            data.append('name', this.item.name);
            data.append('floor', this.item.floor);
            data.append('location', this.item.location);
            data.append('latitude', this.item.latitude);
            data.append('longitude', this.item.longitude);
            data.append('availability', this.item.availability);
            data.append('waze_link', this.item.waze_link);
            data.append('google_map_link', this.item.google_map_link);
            data.append('description', this.item.description);
            data.append('path', this.item.path);
            // data.append('amenity_name[]', this.item.amenity_name);
            axios.post(this.submiturl, data)
                .then(response => {
                    console.log(response.data.message);
                    EventBus.$emit('success-modal');
                })
        },

        buildingImage(e) {

            var files = e.target.files || e.dataTransfer.files;

            if(!files.length)
                return;

            this.item.image = files[0];

            var filereader = new FileReader();
            filereader.readAsDataURL(files[0]);

            filereader.onload = function (event) {
                document.getElementById("img").src = event.target.result;
            };

            this.hidden = false;
        },

        load(value) {
            this.loading = value;
        },

        positionFetch(position) {
            alert(position.message);
            this.item.latitude = position.latitude;
            this.item.longitude = position.longitude;
        },

        viewImage(image) {
            return 'storage/'+image;
        }
    },
}
</script>