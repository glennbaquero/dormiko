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
            :headers="['Item', 'Duration', 'Due Date', 'Amount', 'Notes', 'Status']"
            :columns="['item', 'name', 'duration', 'due_date', 'amount', 'note', 'status']"
    		:filters="filters"
    		
    		:fetchurl="fetchurl"
    		:actionable="actionable"
    		:selectable="false"

    		@loaded="init"
    		@loading="load"
    		>

    			<tbody slot="body">
                    <template v-for="item in items">
                        <tr v-for="utility in item.utilities">
                            <td>{{ utility.item }}</td>
                            <td>{{ utility.duration }}</td>
                            <td>{{ utility.due_date }}</td>
                            <td>{{ utility.amount }}</td>
                            <td>
                                <p style="white-space: nowrap; width: 50px; overflow: hidden; text-overflow: ellipsis;">
                                    {{ item.note }}
                                </p>
                            </td>
                            <td>
                                <span  v-if="utility.invoice.status !== 1" :class="utility.stylelabel" style="border-radius: 4px;">{{ utility.label }}</span>
                                <span  v-if="utility.invoice.status === 1" class="btn-success btn-flat btn-xs" style="border-radius: 4px;">PAID</span>
                            </td>
                            <td v-if="utility.invoice.status !== 1">
                                <a :href="utility.actions.paymenturl" class="btn btn-primary btn-flat btn-sm">Pay</a>
                            </td>
                            <td v-if="utility.invoice.status === 1">
                                <a :href="utility.actions.print" class="btn btn-primary btn-flat btn-sm">Print Invoice</a>
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

    import DataTable from '../../components/DataTable.vue';
    import Loader from '../../components/Loader.vue';
    import Filter from '../../components/Filter.vue';
    import SearchBox from '../../components/SearchBox.vue';

    export default {

    	props: {
    		fetchurl: String,
            viewurl: String,
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