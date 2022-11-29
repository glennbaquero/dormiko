<template>

    <div class="box box-widget m-margin-tb">
    	<div class="box-body">

    		<loader
            :loading="loading"
            ></loader>
    		
    		<div class="row">
                <!-- FILTERS -->
                <div class="col-sm-6 hidden-xs form-inline">
                    <dynamic-filter-box v-show="auth === 0"
                    @onfilter="filterByBuilding"
                    :filters="filterbuilding"
                    :labelcolumn="'name'"
                    :defaultlabel="'Building'"
                    ></dynamic-filter-box>
                </div>

    			<!-- SEARCHBOX -->
    			<div class="col-sm-3 pull-right">
                    <search-box
                    @onsearch="search"
                    ></search-box>
                </div>
    		</div>

    		<!-- DATATABLE -->
    		<datatable ref="datatable"
            :headers="['Date Applied', 'Name', 'Notes', 'Start Date', 'End Date']"
            :columns="['created_at', 'name', 'notes', 'start_date', 'end_date']"
    		:filters="filters"
    		
    		:fetchurl="fetchurl"
    		:actionable="actionable"
    		:selectable="false"

    		@loaded="init"
    		@loading="load"
    		>

    			<tbody slot="body">
                    <tr v-for="item in items" v-show="item.status == status">
                        <td>{{ item.created_at }}</td>
                        <td>{{ item.name }}</td>
                        <td style="text-overflow: ellipsis; width: 20em; margin: 0 0 10em 0">{{ item.message }}</td>
                        <td>{{ item.movein }}</td>
                        <td>{{ item.moveout }}</td>
                        <td v-show="actionable">
                            <template v-if="status == 0">
                                <a :href="item.actions.view" class="btn btn-primary btn-flat btn-sm">Approve</a>
                                <a :href="item.actions.deny" class="btn btn-danger btn-flat btn-sm">Deny</a>
                            </template>
                            <a :href="item.actions.view" class="btn btn-default btn-flat btn-sm">View</a>
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
    import DynamicFilter from '../../components/DynamicFilter.vue';
    import SearchBox from '../../components/SearchBox.vue';

    export default {

    	props: {
            auth: Number,
            status: Number,
    		fetchurl: String,
            approveurl: String,
            autofetch: Boolean,
            actionable: {
                default: true,
            },
            filterstatus: {},
            filterbuilding: {},
    	},

    	components: {
    		'datatable': DataTable,
    		'loader': Loader,
            'search-box': SearchBox,
            'filter-box': Filter,
            'dynamic-filter-box': DynamicFilter,
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
            
            filterByBuilding(value) {
                this.filters = Object.assign(this.filters, { type: value });
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