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
            :headers="['Tenant ID', 'Name', 'Type', 'Duration', 'Due Date', 'Notes', 'Status', 'Amount', 'Penalties', 'Reference Code', 'Payment Date']"
            :columns="['tenant_id', 'name', 'type', 'duration', 'due_date',  'note', 'status', 'amount', 'penalty', 'reference_code', 'payment_date']"
    		:filters="filters"
    		
    		:fetchurl="fetchurl"
    		:actionable="actionable"
    		:selectable="false"

    		@loaded="init"
    		@loading="load"
    		>

    			<tbody slot="body">
                    <template v-for="item in items" v-show="item.status == show">
                        <tr >
                            <td>{{ item.tenant_id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.type }}</td>
                            <td>{{ item.duration }}</td>
                            <td>{{ item.due_date }}</td>
                            <td>
                                <p style="white-space: nowrap; width: 50px; overflow: hidden; text-overflow: ellipsis;">
                                    {{ item.note }}
                                </p>
                            </td>
                            <td>
                                <span class="btn-primary btn-flat btn-xs" style="border-radius: 4px;">
                                    Paid
                                </span>
                            </td>
                            <td>{{ item.amount }}</td>
                            <td>{{ item.penalty }}</td>
                            <!-- <td>{{ item.payment_method }}</td> -->
                            <td>{{ item.reference_code }}</td>
                            <td>{{ item.payment_date }}</td>
                            <td>
                                <a :href="item.actions.view" class="btn btn-default btn-flat btn-sm">View</a>
                            </td>
                        </tr>
                    </template>
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

    export default {

    	props: {
            show: Number,
    		fetchurl: String,
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