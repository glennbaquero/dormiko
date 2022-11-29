<template>
	<a @click.prevent="fetch" href="#" class="btn btn-xs btn-warning"><i class="fas fa-map-pin"></i></a>
</template>

<script>
export default {
	props: {
		fetchurl: {},
		address: {}
	},

	data() {
		return {

		};
	},

	methods: {
		fetch() {
			axios.post(this.fetchurl, {
				location: this.location,
			}).then(response => {
				const data = response.data;

				this.$emit('onfetch', data);
			}).catch(error => {
				this.showErrors(error);
			});
		}
	},
}
</script>