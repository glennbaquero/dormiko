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
            :headers="['Type', 'Item', 'Status', 'Due Date']"
            :columns="['type_id', 'item', 'status', 'due_date']"
            :filters="filters"
            
            :fetchurl="fetchurl"
            :actionable="actionable"
            :selectable="false"

            @loaded="init"
            @loading="load"
            >

                <tbody slot="body">
                    <tr v-for="item in items">
                        <td>Rent</td>
                        <td>--</td>
                        <td><span class="btn-primary btn-flat btn-xs" style="border-radius: 4px;">{{ item.rent_status }}</span></td>
                        <td>{{ item.rent_duedate }}</td>
                        <td v-show="item.show">
                            <a :href="item.actions.view" class="btn btn-primary btn-flat btn-sm">Pay</a>
                        </td>
                    </tr>
                    <template v-for="item in items">
                        <tr v-for="utility in item.utilities">
                            <td>Utility</td>
                            <td>{{ utility.name }}</td>
                            <td><span class="btn-primary btn-flat btn-xs" style="border-radius: 4px;">{{ utility.utility_status }}</span></td>
                            <td>{{ utility.utility_duedate }}</td>
                            <td>
                                <a :href="utility.actions.pay" class="btn btn-primary btn-flat btn-sm">Pay</a>
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

    import {EventBus} from '../../../EventBus.js';

    import DataTable from '../../../components/DataTable.vue';
    import Loader from '../../../components/Loader.vue';
    import Filter from '../../../components/Filter.vue';
    import SearchBox from '../../../components/SearchBox.vue';

    export default {

        props: {
            fetchurl: String,
            viewurl: String,
            checkouturl: String,
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