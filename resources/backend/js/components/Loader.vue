<template>

    <transition name="fade">
        <div v-if="loading"
        class="loader">
            <div class="loader-inner">
                <div class="loader-wrapper">
                    <div class="loader-circle">
                        <div class="loader-circle1 loader-child"></div>
                        <div class="loader-circle2 loader-child"></div>
                        <div class="loader-circle3 loader-child"></div>
                        <div class="loader-circle4 loader-child"></div>
                        <div class="loader-circle5 loader-child"></div>
                        <div class="loader-circle6 loader-child"></div>
                        <div class="loader-circle7 loader-child"></div>
                        <div class="loader-circle8 loader-child"></div>
                        <div class="loader-circle9 loader-child"></div>
                        <div class="loader-circle10 loader-child"></div>
                        <div class="loader-circle11 loader-child"></div>
                        <div class="loader-circle12 loader-child"></div>
                    </div>
                </div>
            </div>
        </div>    
    </transition>

</template>
<script>
    
    /**
     * ==================================================================================
     * Loader for VUE components
     *
     * Required PROPS:
     * - loading variable
     * 
     * ==================================================================================
     **/    

    export default {
        props: {
            loading: Boolean
        },
    }
</script>