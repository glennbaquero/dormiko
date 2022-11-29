<template>

    <span>

        <button :disabled="loading" v-confirm="{ 
            ok: dialog => submitPost(),
            message: '<p>Are you sure you want to proceed?</p>'
        }"
        class="mie-button s-margin-r">
            <i class="fa material-icons">{{ isArchived ? 'restore' : 'delete' }}</i>
            {{ isArchived ? 'Restore' : 'Archive' }}
        </button>
            
    </span>

</template>
<script>

    /**
     * ==================================================================================
     * Component to perform Restore & Archive posts
     * 
     * ==================================================================================
     **/

    import ResponseHandler from '../mixins/ResponseHandler.js';


    export default {

        props: {
            trashed: String,
            destroyurl: String,
            restoreurl: String,          
        },

        data: function() {
            return {
                loading: false,
                isArchived: false,
            };
        },

        mixins: [
            ResponseHandler
        ],

        mounted: function() {
            this.init();
        },

        methods: {

            init: function() {
                
                /* Set default variables */
                this.isArchived = this.trashed;
            },


            /**
             * ==================================================================================
             * @Methods
             * ==================================================================================
             **/      

            /**
             * Reset all variable
             */
            resetAll: function() {
                //

                this.setLoading(false);
            },

            /**
             * Enable/Disable loading state
             * 
             * @param boolean
             */
            setLoading: function(loading) {
                this.loading = loading;
            },          

            /**
             * Send form post
             */
            submitPost: function() { //console.log(this.errors);
                let post = {};
                let url = '';

                /* Prepare variable depending on current status */
                if(this.isArchived) {

                    url = this.restoreurl;

                } else {

                    post = { _method: 'DELETE' };
                    url = this.destroyurl;
                }


                /* Enclose post function on nextTick to make sure vars are updated */                
                this.$nextTick(() => {

                    /* Check loading */
                    if(this.loading)
                        return false;

                    this.setLoading(true);


                    axios.post(url, post)
                        .then((response) => {

                            /* Check AJAX result */
                            if(response.status == 200) {

                                /* Display success message */
                                this.parseSuccess(response); console.log(response.data.response);

                                /* Update status */
                                this.isArchived = !response.data.response;

                                this.resetAll();
                            }
                        })
                        .catch((error) => {

                            /* Display error message */
                            this.parseError(error);

                            this.loading = false;
                        });     
                });           
            },           


            /**
             * ==================================================================================
             * @Checker
             * ==================================================================================
             **/
        }
    }
</script>
