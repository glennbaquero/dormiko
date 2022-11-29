<template>
    <div class="col-xs-12">
        <a :href="addcontracturl" class="btn btn-flat btn-primary">ADD NEW TENANT</a>
        <button class="btn btn-default btn-flat pull-right" style="background: transparent; border:none; margin-right: 43px" @click="exportData"><img src="splices/Icons/Web App/export.svg">Export</button> 
        
            <div class="box box-widget nav-tabs-custom table-responsive">
                <div class="tab-content">
                    <div class="tab-pane active" id="pages">
                        <div class="box box-widget m-margin-tb">
                        	<div class="box-body">
                        		<loader
                                :loading="loading"
                                ></loader>
                        		
                        		<div class="row">
                                    <!-- FILTERS -->
                                    <div class="col-sm-6 hidden-xs form-inline">
                                        <filter-box v-show="filterstatus.length > 0"
                                        @onfilter="filterByStatus"
                                        :filters="filterstatus"
                                        :defaultlabel="'Contracts'"
                                        ></filter-box>


                                        <dynamic-filter-box v-show="auth === 0"
                                        @onfilter="filterByBuilding"
                                        :filters="filterbuilding"
                                        :labelcolumn="'name'"
                                        :defaultlabel="'Building'"
                                        ></dynamic-filter-box>

                                        <room-filter-box v-show="filterroom.length > 0"
                                        @onfilter="filterByRoom"
                                        :rooms="selectedrooms"
                                        :labelcolumn="'unit_name'"
                                        :defaultlabel="'Unit'"
                                        ></room-filter-box>

                                        <selection-filter-box v-show="filterselect.length > 0"
                                        @onfilter="filterSelect"
                                        :selections="filterselect"
                                        ></selection-filter-box>

                                        <selected-filter-box v-show="filterselect.length > 0"
                                        @onfilter="filterByYear"
                                        :selects="selectedFilter"
                                        :labelcolumn="'start_date'"
                                        ></selected-filter-box>

                                    </div>

                        			<!-- SEARCHBOX -->
                        			<div class="col-sm-3 pull-right">
                                        <search-box
                                        @onsearch="search"
                                        ></search-box>
                                    </div>
                        		</div>

                        		<!-- DATATABLE -->
                        		<!-- DATATABLE -->
                                <datatable ref="datatable"
                                :headers="['Tenant ID', 'Name', 'Contract', 'Contract Start', 'Contract End', 'Building', 'Unit No']"
                                :columns="['tenant_id', 'name', 'status', 'duration_from', 'duration_to', 'building', 'unit']"
                                :filters="filters"
                                
                                :fetchurl="fetchurl"
                                :actionable="actionable"
                                :selectable="false"

                                @loaded="init"
                                @loading="load"
                                >

                                    <tbody slot="body">
                                        <tr v-for="item in items">
                                            <td>{{ item.tenant_id }}</td>
                                            <td>{{ item.name }}</td>
                                            <td><span :class="item.status_class" style="border-radius: 4px;">{{ item.status_label }}</span></td>
                                            <td>{{ item.duration_from }}</td>
                                            <td>{{ item.duration_to }}</td>
                                            <td>{{ item.building }}</td>
                                            <td>{{ item.unit }}</td>
                                            <td>
                                                <a :href="item.actions.edit" class="btn btn-warning btn-flat btn-sm">Edit</a>
                                                <a :href="item.actions.view" class="btn btn-primary btn-flat btn-sm">Renew</a>
                                                <a :href="item.actions.evict" v-if="showEvictButton(item)" class="btn btn-danger btn-flat btn-sm" > Move out </a>
                                                <button @click="restoreTenant(item)" v-if="!showEvictButton(item)" class="btn btn-danger btn-flat btn-sm" > Tenant is moved out </button>
                                            </td>
                                        </tr>
                                    </tbody>

                                </datatable>
                        	</div>
                        </div>
                     </div>
                 </div>
             </div>
         </div>
</template>
<script>

    /**
     * ==================================================================================
     * Template component using DataTable.vue
     * 
     * ==================================================================================
     **/

    import {EventBus} from '../../EventBus.js';

    import DataTable from '../../components/DataTable.vue';
    import Loader from '../../components/Loader.vue';
    import Filter from '../../components/Filter.vue';
    import SearchBox from '../../components/SearchBox.vue';
    import DynamicFilter from '../../components/DynamicFilter.vue';
    import RoomFilter from '../../components/RoomFilter.vue';
    import SelectedFilter from '../../components/SelectedFilter.vue';
    import SelectionFilter from '../../components/SelectionFilter.vue';

    export default {

    	props: {
            auth: Number,
    		fetchurl: String,
            renewurl: String,
            exporturl: String,
            addcontracturl: String,
            autofetch: Boolean,
            actionable: {
                default: true,
            },
            filterstatus: {},
            filterbuilding: {},
            filterroom: {},
            filteryear: {},
            filtermonth: {},
            filterselect: {},
    	},

    	components: {
    		'datatable': DataTable,
    		'loader': Loader,
            'search-box': SearchBox,
            'filter-box': Filter,
            'dynamic-filter-box': DynamicFilter,
            'room-filter-box': RoomFilter,
            'selected-filter-box': SelectedFilter,
            'selection-filter-box': SelectionFilter,
    	},

    	data: function() {
    		return {

    			loading:false,
    			initiated:false,
    			
    			items: [],
                filters: {},
    			buildings: [],
                rooms: [],

                selectedrooms: [],

                yearFilter: [],

                selectedFilter: [],

    			searchbox:null,
    			filter:null,

                datas: [],
    		};
    	},

    	watch: {

    		filter: function(val) {

    			this.filters = Object.assign(this.filters, { filter: val });
    			this.fetch();
    		},
    	},

    	methods: {

    		/**
    	     * Receives fetched data for rendering.
    	     */
    		init: function(val) {

                /* Initialize default variables */
    			this.items = val;
    			this.initiated = true;

                /* Fire off re-init */
                EventBus.$emit('re-init', { el: this.$el });
    		},


            /**
             * ==================================================================================
             * @Methods
             * ==================================================================================
             **/

    		/**
    	     * Search keyword.
    	     */
    	    search:function(value) {
                this.filters = Object.assign(this.filters, { search: value });
                this.fetch();
            },

            filterByStatus(value) {
                this.filters = Object.assign(this.filters, { status: value });
                this.fetch();
            },
            
            filterByBuilding(value) {
                this.filters = Object.assign(this.filters, { type: value });
                this.selectedrooms = this.filterroom.filter((room) => { return room.building_id == value});
                this.fetch();
            },

            filterByRoom(value) {
                this.filters = Object.assign(this.filters, { room: value });
                this.fetch();
            },


            filterByYear(value) {
                this.filters = Object.assign(this.filters, { duration_from: value });
                this.fetch();
            },

            filterSelect(value) {
                if(value === 'Year') {
                    this.selectedFilter = this.filteryear;
                } else {
                    this.selectedFilter = this.filtermonth;
                }
            },
    		/**
    	     * Add filter to request and then fetch.
    	     */
    		fetch: function() {

    			this.$nextTick(() => {
    				
    				if(this.initiated) {
    					this.$refs.datatable.fetch();
    				}
    			});
    		},

    		/**
    	     * Toggles loading animation.
    	     */
    		load: function(val) {
    			this.loading = val;
    		},

            exportData() {
                var data = {
                    items: this.items
                };

                console.log(data);

                // axios.post(this.exporturl, data)
                //     .then(response => {
                //         console.log(response.data);
                //     })


                axios.post(this.exporturl, data, {responseType: 'blob'})
                    .then(response=>{
                        var filename = "";
                        var disposition = response.request.getResponseHeader('Content-Disposition');

                        if (disposition) {
                            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            var matches = filenameRegex.exec(disposition);
                            if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                        }

                        var linkelem = document.createElement('a');
                        try {
                        var blob = new Blob([response.data], { type: 'application/octet-stream' });                        

                            if (typeof window.navigator.msSaveBlob !== 'undefined') {
                                //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                                window.navigator.msSaveBlob(blob, filename);
                            } else {
                                var URL = window.URL || window.webkitURL;
                                var downloadUrl = URL.createObjectURL(blob);

                                if (filename) { 
                                    // use HTML5 a[download] attribute to specify filename
                                    var a = document.createElement("a");

                                    // safari doesn't support this yet
                                    if (typeof a.download === 'undefined') {
                                        window.location = downloadUrl;
                                    } else {
                                        a.href = downloadUrl;
                                        a.download = filename;
                                        document.body.appendChild(a);
                                        a.click();
                                    }
                                } else {
                                    window.location = downloadUrl;
                                }
                            }   

                        } catch (ex) {
                            console.log(ex);
                        }
                    })
                    .catch(error => {
                        toastr.error(error, 'Invalid');
                    });
                console.log(this.filters);
            },

            isClickable(clickable) {
                return clickable === 1 ? 'pointer-events: true' : 'pointer-events: none';
            },

            showEvictButton(item) {
                var show = true;

                if(item.status === 3 || item.status === 0) {
                    show = false;
                } 

                return show;
            },

            restoreTenant(item) {
                var data = {};
                swal({
                    title: 'Tenant Renewal',
                    text: 'Are you sure you want to activate and renew the tenant?',
                    type: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Yes, restore tenant'
                }).then((result) => {
                    if (result.value) {
                        swal({
                            title: 'Success',
                            text: 'Tenant renewed!',
                            type: 'success',
                            showCancelButton: false,
                            reverseButtons: false,
                        }).then((result) => {
                            axios.post(item.actions.restore, data)
                            .then(response => {
                                this.fetch()
                            })
                        })
                    }
                })
                
            }
    	}
    }
</script>