<template>

    <div class="box box-widget m-margin-tb">
    	<div class="box-body">

    		<loader
            :loading="loading"
            ></loader>
    		
    		<div class="row">
                <!-- FILTERS -->
                <div class="col-sm-6 hidden-xs form-inline">
                    <!-- <filter-box v-show="filterstatus.length > 0"
                    @onfilter="filterByStatus"
                    :filters="filterstatus"
                    :defaultlabel="'Filter by Status'"
                    ></filter-box> -->
                </div>

    			<!-- SEARCHBOX -->
    			<div class="col-sm-3 pull-right">
                    <!-- <search-box
                    @onsearch="search"
                    ></search-box> -->
                </div>
    		</div>

    		<!-- DATATABLE -->
    		<datatable ref="datatable"
            :headers="['Tenant ID', 'Name', 'Status', 'Contract Start', 'Contract End', 'Building', 'Unit No']"
            :columns="['tenant_id', 'name', 'status', 'duration_from', 'duration_to', 'building', 'unit']"
    		:filters="filters"
    		
    		:fetchurl="fetchurl"
    		:actionable="actionable"
    		:selectable="false"

    		@loaded="init"
    		@loading="load"
    		>

    			<tbody slot="body">
                    <tr v-for="item in items" v-if="room === item.room_id">
                        <td>{{ item.tenant_id }}</td>
                        <td>{{ item.name }}</td>
                        <td><span :class="item.status_class" style="border-radius: 4px;">{{ item.status_label }}</span></td>
                        <td>{{ item.duration_from }}</td>
                        <td>{{ item.duration_to }}</td>
                        <td>{{ item.building }}</td>
                        <td>{{ item.unit }}</td>
                        <td>
                            <a :href="item.actions.view" class="btn btn-primary btn-flat btn-sm">View</a>
                        </td>
                    </tr>
    			</tbody>

    		</datatable>
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

    export default {

    	props: {
            room: Number,
    		fetchurl: String,
            renewurl: String,
            autofetch: Boolean,
            actionable: {
                default: true,
            },
            filterstatus: {},
    	},

    	components: {
    		'datatable': DataTable,
    		'loader': Loader,
            'search-box': SearchBox,
            'filter-box': Filter,
    	},

    	data: function() {
    		return {

    			loading:false,
    			initiated:false,
    			
    			items: [],
    			filters: {},

    			searchbox:null,
    			filter:null,
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
    	}
    }
</script>