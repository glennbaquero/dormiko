<template>
	<div>
		<label for="">{{ label }} <a @click.prevent="add" href="#" class="btn btn-xs btn-primary"><i class="fas fa-plus"></i></a></label>
	    <template v-for="(item, index) in items">
	    	<div class="mb-3">
				<div class="input-group input-group-sm">
			        <input v-if="items[index]" @change="change(index, $event)" v-model="items[index].name" :disabled="disabled" :name="name" type="text" class="form-control input-sm" :placeholder="placeholder" autocomplete="nope">
			        <input v-if="items[index]" @change="change(index, $event)" v-model="items[index].id" :disabled="disabled" name="id[]" type="text" class="form-control input-sm" placeholder="ID" v-show="false" autocomplete="nope">
			        <input v-if="!items[index]" :disabled="disabled" :name="name" type="text" class="form-control input-sm" :placeholder="placeholder" autocomplete="nope">
			        <input v-if="!items[index]" value="0" :disabled="disabled" name="id[]" type="text" class="form-control input-sm" placeholder="ID" v-show="false" autocomplete="nope">
			         <input :disabled="disabled" name="images[]" type="file" class="form-control input-sm">
			        <div class="input-group-btn">
		              <button @click.prevent="remove(index, items[index].id)" type="button" class="btn btn-danger"><i class="fas fa-times"></i></button>
		            </div>
				</div>
	    	</div>
	    </template>
	</div>
</template>

<script>
export default {
	props: {
		label: {},
		placeholder: {},
		name: {},
		disabled: {},
		list: {},
	},

	data() {
		return {
			items: [null],
		};
	},

	watch: {
		list(newItems, oldItems) {
			this.items = newItems ? newItems : this.items;
			this.$emit('sendData', this.items)
		},
	},

	mounted() {

	},

	methods: {
		add() {
			this.items.push(null);
		},

		remove(index, id) {
			this.items.splice(index, index + 1);
			var destroy = 'admin/amenity/destroy/'+id;
			axios.delete(destroy)
				.then(response => {
					console.log('deleted');
				});
		},

		change(index, event) {
			this.items[index] = event.target.value;
		},

		// renderImage(img) {
		// 	return 'storage/'+img;
		// }
	},
}
</script>