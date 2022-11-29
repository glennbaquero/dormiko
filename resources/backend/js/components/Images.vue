<template>
	<div>
	    <template v-for="(item, key) in items">
	    	<div class="d-inline pr-3">
	    		<a :href="item.path" target="_blank">
		        	<img :src="item.path" class="img-thumbnail img-responsive d-inline image-remove" width="75" height="75">
	        	</a>
	        	<button @click.prevent="remove(item.url)" type="button" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
			</div>
	    </template>
    </div>
</template>
<script>
	export default {
		props: {
			items: Array,
		},

		methods: {
			remove(url) {
				if(confirm('Do you want to remove the image from slider?')) {
					axios.post(url)
					.then(response => {
						this.$emit('on-delete');
					});
				}
			}
		}
	}
</script>