<template>

    <div class="table-responsive">

        <table class="table text-center table-hover">

            <!-- /*---------------------------------------------------
            | <thead> Used for sorting and mass selection
            |---------------------------------------------------*/ -->
            <thead>
                <tr>
                    <th v-if="selectable">
                        <input type="checkbox" v-model="selectAll">
                    </th>
                    <th v-for="(header,index) in headers">
                        <span v-if="sortable && columns[index]"
                        class="sorter" @click="setSort(columns[index])">
                            {{ header }} &nbsp; 
                            <i :class="renderSort(columns[index])"></i>
                        </span>
                        <span v-else>
                            {{ header }}
                        </span>
                    </th>
                    <th v-show="actionable">Actions</th>
                    <th v-if="selectable">
                        <input type="checkbox" v-model="selectAll">
                    </th>
                </tr>
            </thead>
            
            <!-- /*---------------------------------------------------
            | <slot> body
            |---------------------------------------------------------
            |
            | Emit fetched database data to parent component where
            | they can use this slot to render that data
            |
            */ -->
            <slot name="body"></slot>

            <tbody v-if="empty && !customEmpty">
                <tr>
                    <td :colspan="colspan">No Items Found</td>
                </tr>
            </tbody>

            <!-- /*---------------------------------------------------
            | <tfoot> Used for sorting and mass selection
            |---------------------------------------------------*/ -->
            <!-- <tfoot>
                <tr>
                    <th v-if="selectable"><input type="checkbox" v-model="selectAll"></th>
                    <th v-for="(header,index) in headers">
                        <span class="sorter" @click="setSort(columns[index])" v-if="sortable">
                            {{ header }} &nbsp; <i :class="renderSort(columns[index])"></i>
                        </span>
                        <span v-else>
                            {{ header }}
                        </span>
                    </th>
                    <th v-show="actionable">Actions</th>
                </tr>
            </tfoot> -->

        </table>

        <pagination ref="page"
        :fetchurl="url"
        :autofetch="autofetch"
        :visible="paginated"

        @total="init"
        @paginate="fetch"
        ></pagination>

    </div>

</template>
<script>

    /**
     * ==================================================================================
     * Data Table VUE component to be used together w/ Laravel's Pagination response
     *
     * Required VUE:
     * - resources/js/components/Pagination.vue;
     *
     * Required JS:
     * - Axios
     * 
     * ==================================================================================
     **/

    import Pagination from './Pagination.vue';

    export default {

        props: {
            fetchurl: String,

            /**
             * Table header columns
             */
            headers: Array,
            
            columns: Array,
            filters: Object,

            /**
             * Default column to sort
             */
            defaultsort: {
                type: String,
                default: null,
            },

            /**
             * Default order for the sorting
             *
             * Ascending = TRUE
             * Descending = FALSE
             */
            defaultorder: {
                type: Boolean,
                default: false,
            }, 

            /**
             * Enable autofetch
             */
            autofetch: {
                type: Boolean,
                default: true,
            },

            /**
             * Adds a "Action" column at the end of the table
             */
            actionable: {
                default: true
            },

            /**
             * Adds a checkbox column at the start of the table
             */
            selectable: {
                type: Boolean,
                default: false
            },

            /**
             * Enables sorting on the table header
             */
            sortable: {
                type: Boolean,
                default: true
            },

            paginated: {
                type: Boolean,
                default: true
            },

            customEmpty: {
                type: Boolean,
                default: false
            }
        },

        components: {
            'pagination': Pagination,
        },

        data: function() {
            return {
                loading: false,
                empty: false,
                
                url: null,

                total: null,
                sort: 'id',
                asc: true,

                selectAll: false,
                selectEmit: true,
            };
        },

        watch: {
            selectAll: function(val) {
                
                if(this.selectEmit) {
                    this.$emit('select', val);
                }

                this.selectEmit = true;
            }
        },

        computed: {
            colspan: function() {
                return this.headers.length + (this.actionable ? 1 : 0) + (this.selectable ? 1 : 0);
            }
        },

        mounted() {
            this.init();
        },

        methods: {

            /**
             * Initialize data-table on pagination's mounted hook.
             *
             * @param mixed total
             */
            init: function(total = null) {

                /* Set default variables */
                this.url = this.fetchurl;
                this.total = total;
                this.initSettings();


                /* Run fetch if autofetch is toggled */
                if(this.autofetch)
                    this.fetch();
            },

            /**
             * Initialize fetch parameters
             */
            initSettings: function() {
                this.sort = this.defaultsort ? this.defaultsort : this.sort; //console.log(this.defaultsort);
                this.asc = this.defaultorder !== null ? this.defaultorder : this.asc; //console.log(this.defaultorder);
            },


            /**
             * ==================================================================================
             * @Methods
             * ==================================================================================
             **/

            /**
             * Returns URL with parameters.
             *
             * @param string url
             */
            getURL: function(url) {

                /* order by */
                url = this.sort ? this.addURLParam('sort', this.sort, url) : url;

                /* asc, desc */
                url = this.addURLParam('order', this.asc ? 'asc' : 'desc', url);

                /* paginate(total) */
                url = this.total > 0 ? this.addURLParam('total', this.total, url) : url;


                /* filters and search query */
                Object.keys(this.filters).forEach(key => {

                    var val = this.filters[key];
                    url = val ? this.addURLParam(key, val, url) : url;
                });

                return url;
            },

            /**
             * Update URL string
             * 
             * @param string url
             */
            setURL: function(url) {
                this.url = url;

                /* Add in settings */
                this.initSettings();
                /* Refresh list */
                this.fetch(this.url);
            },

            /**
             * Sorts table according to selected column.
             *
             * @param string col
             */
            setSort: function(col) {
                
                if(this.sort == col) {
                    this.asc = !this.asc;

                } else {
                    this.sort = col;
                    this.asc = true;
                }

                this.fetch();
            },

            /**
             * Enable/Disable loading state
             * 
             * @param boolean loading
             */
            setLoading: function(loading) {
                this.loading = loading;

                /* Dispatch loading state */
                this.$emit('loading', this.loading);
            },

            /**
             * Fetch data from server.
             *
             * @param string link
             */
            fetch: function(link = null) {

                /* Check loading */
                if(this.loading)
                    return false;


                this.setLoading(true);
                

                /*
                |-------------------------------------------------------------
                | @var URL
                |-------------------------------------------------------------
                |
                | The first LINK is received from the pagination component.
                | The second FILTEREDURL is received from parent component
                | that handles filters and searches. The third FETCHURL is
                | the initial route hardcoded in blade.
                |
                | Prioritizes leftmost variable if it has a value.
                |
                */
                var url = link || this.url;

                axios.post(this.getURL(url))
                    .then(response => {

                        /* Emit data for parent component to render */
                        var items = response.data.items;
                        /* Dispatch loaded item */
                        this.$emit('loaded', items);

                        /* Update pagination */
                        this.$refs.page.pagination = response.data.pagination;
                        /* Check item length */
                        this.empty = items.length ? false : true;


                        this.setLoading(false);
                    });
            },


            /**
             * ==================================================================================
             * @Render
             * ==================================================================================
             **/

            /**
             * Returns appropriate sort icon.
             *
             * @param string col
             */
            renderSort: function(col) {

                if(this.sort == col) {
                    return this.asc ? 'fa fa-sort-up active' : 'fa fa-sort-down active';
                }

                return 'fa fa-sort';
            },            
        }
    }
</script>