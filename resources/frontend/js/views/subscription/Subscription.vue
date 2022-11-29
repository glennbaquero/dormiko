<template>
	<div>
		<loading
		:display="display">
		</loading>
		<div class="subscribe__holder">
			<input class="subscribe__input" type="email" name="email" v-model="item.email" placeholder="Email Address" required>
			<button class="subscribe__button btn" @click="subscribe">OK</button>
		</div>
	</div>
</template>

<script>
	import Loading from '../includes/Loading.vue';
	export default {
		props: {
			storeurl: String
		},

		components: {
			'loading': Loading
		},

		data() {
			return {
				item: {},
				display: 'none',
			};
		},

		methods: {
			subscribe() {
				this.display = 'block';
				var data = new FormData();

				data.append('email', this.item.email);
				axios.post(this.storeurl, data)
					.then(response => {
						if(response.data.message) {
							this.display = 'none';
							swal('Thank you for subscribing!', 'Thank you for subscribing!', 'success');
						}


					})
					.catch(error => {
						this.display = 'none';
						swal('Oooops', error.response.data.errors.email[0], 'error');
					});
			}
		}

	}
</script>