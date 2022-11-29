<template>

    <div class="dataTables_wrapper" v-if="visible">
        <div class="row">
                
            <div v-show="pagination.total > limits[0]" class="col-sm-6">
                <!-- /*-----------------------------------------------------------
                | Item Limit
                |-----------------------------------------------------------*/ -->
                <div class="dataTables_length">
                    <label>
                        Show &nbsp;
                        <select ref="pageLimit" v-model="total" @change="fetch()" class="form-control input-sm">

                            <template v-for="(limit, index) in limits">
                                <option :value="limit" v-show="pagination.total > limits[index > 0 ? index - 1 : 0]">{{ limit }}</option>
                            </template>

                        </select>
                        &nbsp; entries
                    </label>
                </div>

            </div>

            <div v-show="pagination.last !== 1" class="col-sm-6">
                
                <!-- /*-----------------------------------------------------------
                | Pagination Bar
                |-----------------------------------------------------------*/ -->
                <ul class="pagination pagination-sm no-margin pull-right hidden-sm hidden-xs" style="cursor:pointer">

                    <li><a @click.prevent="prev()">&laquo;</a></li>

                    <li :class="pagination.current === 1 ? 'active' : ''"  @click.prevent="page(1)" v-show="pagination.last !== 1">
                        <a href="#">1</a>
                    </li>

                    <template v-for="n in pagination.last" v-if="pagination.last > 1">
                        <template v-if="Math.abs(n-pagination.current) > limit && Math.abs(n-pagination.current) < (limit+2)">
                            <li class=""><span>...</span></li>
                        </template>

                        <template v-else-if="Math.abs(n-pagination.current) < (limit+2) && (n !== 1 && n !== pagination.last)">
                            <li :class="{ 'active':n == pagination.current }"><a @click.prevent="page(n)" v-text="n"></a></li>
                        </template>
                    </template>

                    <template v-if="pagination.last == 1">
                        <li><span>...</span></li>
                    </template>

                    <li :class="pagination.last === pagination.current ? 'active' : ''" @click.prevent="page(pagination.last)" v-show="pagination.last !== 1">
                        <span>{{ pagination.last }}</span>
                    </li>

                    <li><a @click.prevent="next()">&raquo;</a></li>

                </ul>
            </div>
        </div>


        <div class="row d-flex align-items-center mt-3">
            
            <div class="col-sm-6">
                 <!-- /*-----------------------------------------------------------
                | Show Total
                |-----------------------------------------------------------*/ -->
                <label class="text-muted hidden-sm hidden-xs">
                    Showing 
                    {{ pagination.from == null ? 0 : pagination.from }} to {{ pagination.to == null ? 0 : pagination.to }} of {{ pagination.total == null ? 0 : pagination.total }}
                </label>
            </div>

            <div v-show="pagination.last !== 1" class="col-sm-6">
                <!-- /*-----------------------------------------------------------
                | Jump to Page
                |-----------------------------------------------------------*/ -->
                <div class="dataTables_length text-right">
                    <label>
                        &emsp; Go to Page: &nbsp;
                        <select ref="pageNumber" v-model="current" @change="page()" class="form-control input-sm">
                            <option v-for="x in pagination.last" :value="x" v-text="x"></option>
                        </select>
                    </label>
                </div>
            </div>

        </div>


       
        
    </div>

</template>
<script>

    /**
     * ==================================================================================
     * Pagination VUE component
     *
     * Component of:
     * - resources/js/components/DataTable.vue;
     * 
     * ==================================================================================
     **/

    export default {

        props: {
            fetchurl: String,

            autofetch: {
                type: Boolean,
                default: true
            },

            visible: {
                type: Boolean,
                default: true
            }
        },

        data: function() {
            return {
                total: 10,
                limit: 2,
                current: 1,
                pagination: {},

                limits: [
                    10, 15, 20,
                ],
            };
        },

        mounted: function() {
            
            /* Run fetch if autofetch is toggled */
            if(this.autofetch)
                this.fetch();


            /* Initialize component */
            this.init();
        },

        watch: {
            pagination: function(newval, oldval) {
                this.current = newval.current;
            }
        },

        methods: {

            init: function() {

                /* Set default IDs */
                this.setIDs();
            },


            /**
             * ==================================================================================
             * @Methods
             * ==================================================================================
             **/

            /**
             * Set unique ID of select box
             */
            setIDs: function() {
                this.$refs.pageLimit.id = this.getUniqueID('pagination-page-limit');
                this.$refs.pageNumber.id = this.getUniqueID('pagination-page-no');
            },

            /**
             * Create a unique ID
             * 
             * @return string
             */
            getUniqueID: function(prefix) {
                let tmp = 0;
                let tmpName = prefix + '-' + tmp;

                /* Check availability */
                while(document.getElementById(tmpName)) {
                    tmp++;
                    tmpName = prefix + '-' + tmp;
                }
                
                return tmpName;
            },

            /**
             * Initializes fetch of parent data-table component.
             */
            fetch: function() {
                this.$emit('total', this.total);
                this.$emit('paginate', null);
            },


            /**
             * ==================================================================================
             * @Pagination
             * ==================================================================================
             **/

            /**
             * Go to previous page.
             */
            prev: function() {

                /* Check if prev page exists */
                if(!this.pagination.prevpage)
                    return false;

                this.$emit('paginate', this.pagination.prevpage);
            },

            /**
             * Go to specific page.
             *
             * @param int index
             */
            page: function(index = null) {

                let page = index || this.current;

                /* Check if on current page */
                if(this.pagination.current == page)
                    return false;

                this.$emit('paginate', this.pagination.next+'?page='+page);
            },

            /**
             * Go to next page.
             */
            next: function() {

                /* Check if next page exists */
                if(!this.pagination.nextpage)
                    return false;

                this.$emit('paginate', this.pagination.nextpage);
            }
        }

    }
</script>