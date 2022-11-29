<template>
	<button @click.prevent="confirm()" href="#" :class="btnClass" :disabled="actionable" type="button">
		<i :class="iconClass"></i>
		{{ settings.label }}
	</button>	
</template>

<script type="text/javascript">
export default {
	props: {
		actionurl: String,
		deleteurl: String,
		restoreurl: String,
		action: String,

		method: {
			default: 'delete',
			type: String,
		},

		size: {
			default: 'btn-xs',
			type: String,
		},

		type: {
			default: 'btn-danger',
			type: String,
		},

		icon: {
			default: 'fa-times',
			type: String,
		},

		label: {
			type: String,
		},

		message: {
			type: String,
			default: 'You want to perform this action?'
		},
	},

	data() {
		return {
			loading: false,

			settings: {
				actionurl: this.actionurl,
				label: this.label,
				action: this.action,
				method: this.method,
				size: this.size,
				type: this.type,
				icon: this.icon,
				label: this.label,
				message: this.message,
			},
		};
	},

	computed: {
		btnClass() {
			return 'btn ' + this.settings.size + ' ' + this.settings.type;
		},

		iconClass() {
			let iconClass = 'fa ' + this.settings.icon;

			if (this.settings.label) {
				iconClass = iconClass + ' mr-2';
			}

			return iconClass;
		},

		actionable() {
			return this.loading;
		}
	},

	mounted() {
		this.setup();
		this.init();
	},

	methods: {
		setup() {

		},

		init() {
			this.$nextTick(() => {
				this.setAction(this.settings.action);
			});
		},

		setAction(action) {
			if (!action) { return; }

			switch (action) {
				case 'delete':
						if (this.label) {
							this.settings.label = 'Archive';
						}

						this.settings.message = 'Are you sure you want to delete ' + this.message;
						this.settings.method = 'delete';
						this.settings.type = 'btn-danger';
						this.settings.icon = 'fa-times';
						this.settings.actionurl = this.deleteurl;
						// console.log('delete');
					break;
				case 'restore':
						if (this.label) {
							this.settings.label = 'Restore';
						}
						this.settings.message = 'Are you sure you want to restore ' + this.message;
						this.settings.method = 'post';
						this.settings.type = 'btn-warning';
						this.settings.icon = 'fa-archive';
						this.settings.actionurl = this.restoreurl;
						// console.log('archive');
					break;
			}
		},

		confirm() {
			if (this.loading) { return; }
			this.loading = true;

			const result = confirm(this.settings.message);

			if (result) {
				this.submit();
			} else {
				this.loading = false;
			}
		},

		submit() {
			this.$emit('loading', true);

			axios[this.settings.method](this.settings.actionurl)
			.then(response => {
				this.updateAction(this.settings.action);
				this.alert(response);
				this.$emit('onsuccess');
				this.loading = false;
				this.$emit('loading', false);
			}).catch(error => {
				this.loading = false;
				this.showErrors(error);
				this.$emit('loading', false);
			});
		},

		updateAction(action) {
			if (!action) { return; }

			switch (action) {
				case 'delete':
						this.settings.action = 'restore';
					break;
				case 'restore':
						this.settings.action = 'delete';
					break;
			}

			this.init();
		}
	},
}
</script>