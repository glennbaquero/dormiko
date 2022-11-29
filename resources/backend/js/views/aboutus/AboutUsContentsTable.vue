<template>

    <div class="box box-widget">
        <div class="box-body">

            <loader
            :loading="loading"
            ></loader>

            <div class="row mb-3">
	            
	            <div class="col-sm-4 hidden-xs">

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
            :headers="['#', 'Content', 'Created Date']"
            :columns="['id', 'content', 'created_at']"
            :filters="filters"
            
            :fetchurl="fetchurl"
            :actionable="true"
            :selectable="false"
            :autofetch="autofetch"

            @loaded="init"
            @loading="load"
            >

                <tbody slot="body">
                    <tr v-for="item in items">
                        <!-- <td><input :value="item.id" type="checkbox" v-model="selected"></td> -->
                        <td>{{ item.id }}</td>
                        <td>{{ item.content }}</td>
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
 * ==================================================================================
 **/

import {ebi} from '../../EventBus.js';


import DataTable from '../../components/DataTable.vue';
import Loader from '../../components/Loader.vue';
import SearchBox from '../../components/SearchBox.vue';

export default {

    props:{
        fetchurl: String,
        autofetch: Boolean,
    },

    components:{
        'datatable': DataTable,
        'loader': Loader,
        'search-box': SearchBox,
    },

    data:function() {
        return {
            selected: [],
            loading: false,
            initiated: false,
            
            items: [],
            filters: {},

            filter: null,
        };
    },

    watch:{

        filter:function(val) {

            this.filters = Object.assign(this.filters, { filter: val });
            this.fetch();
        },
    },

    methods:{

        /**
         * Receives fetched data for rendering.
         */
        init:function(val) {

            /* Initialize default variables */
            this.items = val;
            this.initiated = true;

            /* Fire off re-init */
            // ebi.$emit('re-init', { el: this.$el });
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

        /**
         * Add filter to request and then fetch.
         */
        fetch:function() {

            this.$nextTick(() => {
                
                if(this.initiated) {
                    this.$refs.datatable.fetch();
                }
            });
        },

        /**
         * Toggles loading animation.
         */
        load:function(val) {
            this.loading = val;
        },
    }
}
</script>