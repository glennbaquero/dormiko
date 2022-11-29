<template>

    <div class="box box-widget m-margin-tb">
    	<div class="box-body">
            
            <add-rent-penalty></add-rent-penalty>
    		<loader
            :loading="loading"
            ></loader>
    		
    		<div class="row">
                <!-- FILTERS -->
                <div class="col-sm-6 hidden-xs form-inline">
                    <filter-box v-show="filterstatus.length > 0"
                    @onfilter="filterByStatus"
                    :filters="filterstatus"
                    :defaultlabel="'View All'"
                    ></filter-box>
                
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
    		<datatable ref="datatable"
            :headers="['Tenant ID', 'Name', 'Duration', 'Due Date', 'Notes', 'Status', 'Rental Fee', 'Penalties', 'Total']"
            :columns="['tenant_id', 'name', 'duration', 'due_date',  'note', 'status', 'rental_fee', 'penalty', 'total']"
    		:filters="filters"
    		
    		:fetchurl="fetchurl"
    		:actionable="actionable"
    		:selectable="false"

    		@loaded="init"
    		@loading="load"
    		>

    			<tbody slot="body">
                    <tr v-for="item in items">
                        <!-- <template v-for="reservation in item.reservation"> -->
                            <td>{{ item.tenant_id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.duration }}</td>
                            <td>{{ item.due_date }}</td>
                            <td>
                                <p style="white-space: nowrap; width: 50px; overflow: hidden; text-overflow: ellipsis;">
                                    {{ item.reservation.message }}
                                </p>
                            </td>
                            <td>
                                <span class="btn-primary btn-flat btn-xs" style="border-radius: 4px;"  v-if="item.status == 0">
                                    {{ item.label }}
                                </span>
                                <span class="btn-success btn-flat btn-xs" style="border-radius: 4px;"  v-if="item.status == 1">
                                    Paid
                                </span>
                                <span class="btn-danger btn-flat btn-xs" style="border-radius: 4px;"  v-if="item.status == 2">
                                    Overdue
                                </span>
                            </td>
                            <td>{{ item.rental_fee }}</td>
                            <td>{{ item.penalty }} </td>
                            <td>{{ item.total }}</td>
                            <td>
                                <a class="btn btn-danger btn-flat btn-sm" @click="showModal(item, item.id)" :disabled="item.label == 'Overdue' ? false : true">Add Penalty</a>
                                <a :href="item.actions.view" class="btn btn-default btn-flat btn-sm">View</a>
                            </td>
                        <!-- </template> -->
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
    import moment from 'moment'
    import DataTable from '../../components/DataTable.vue';
    import Loader from '../../components/Loader.vue';
    import Filter from '../../components/Filter.vue';
    import SearchBox from '../../components/SearchBox.vue';
    import AddRentPenalty from '../includes/AddRentPenalty.vue';
    import SelectedFilter from '../../components/SelectedFilter.vue';
    import SelectionFilter from '../../components/SelectionFilter.vue';

    export default {

    	props: {
    		fetchurl: String,
            autofetch: Boolean,
            actionable: {
                default: true,
            },
            filterstatus: {},
            filteryear: {},
            filtermonth: {},
            filterselect: {},
    	},

    	components: {
    		'datatable': DataTable,
    		'loader': Loader,
            'search-box': SearchBox,
            'filter-box': Filter,
            'add-rent-penalty': AddRentPenalty,
            'selected-filter-box': SelectedFilter,
            'selection-filter-box': SelectionFilter,
    	},

    	data: function() {
    		return {

    			loading:false,
    			initiated:false,
    			
    			items: [],
    			filters: {},

                yearFilter: [],

                selectedFilter: [],

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

            filterByYear(value) {
                this.filters = Object.assign(this.filters, { due_date: value });
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

            showModal(item, id) {
                if(item.label == 'Overdue') {
                    EventBus.$emit('rent-penalty-modal', { 
                        item: item,
                        penaltyurl: 'admin/rent/penalty/'+id
                    }); 
                }
                
            }
    	}
    }
</script>