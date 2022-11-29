<template>
	<form @submit.prevent="submit()" method="GET" action="#">
        <div class="input-group input-group-sm col-sm-12">

            <input type="text" name="search" v-model="search"
            class="form-control input-sm" placeholder="Search here..." aria-label="Search here...">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-sm btn-primary">Search</button>
            </span>

        </div>
    </form>
</template>

<script>
export default {
	data() {
		return {
			search: null,
		};
	},

	mounted() {

	},

	methods: {
		submit() {
			this.$emit('onsearch', this.search);
		}
	},
}
</script>