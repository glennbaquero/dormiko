<template>

    <div class="box box-widget m-margin-tb">
    	<div class="box-body">

    		<loader
            :loading="loading"
            ></loader>
    		
    		<div class="row">
    			<!-- FILTERS -->
    			<div class="col-sm-6 hidden-xs form-inline">
                    <filter-box v-show="filtertags"
                    @onfilter="filterByTag"
                    :filters="filtertags"
                    :defaultlabel="'Filter by Tag'"
                    :valuecolumn="'id'"
                    :labelcolumn="'name'"
                    ></filter-box>
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
            :headers="['#', 'Name', 'Tags', 'Created At']"
            :columns="['id', 'name', null, 'created_at']"
    		:filters="filters"
    		
    		:fetchurl="fetchurl"
    		:actionable="true"
    		:selectable="false"

    		@loaded="init"
    		@loading="load"
    		>

    			<tbody slot="body">
    				<tr v-for="item in items">
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
    					<td>{{ item.tag_list }}</td>
    					<td>{{ item.created_at }}</td>
                        <td>
                            <center>
                                <a :href="item.actions.view" 
                                class="btn btn-xs btn-primary">
                                    <span class="fa fa-eye"></span>
                                </a>
                            </center>                            
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
    import SearchBox from '../../components/SearchBox.vue';
    import Filter from '../../components/Filter.vue';

    export default {

    	props: {
            fetchurl: String,
    		filtertags: {},
            autofetch: Boolean
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
    	    search: function(value) {
    	    	this.filters = Object.assign(this.filters, { search: value });
    	    	this.fetch();
    	    },

            filterByTag(value) {
                this.filters = Object.assign(this.filters, { tag: value });
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