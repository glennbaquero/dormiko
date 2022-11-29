/**
 * Dropzone mixin
 *-----------------------------------------------*/

export default {

	computed:{

		/* flatpickr vue object */
		dropzone:function() {

			let token = document.head.querySelector('meta[name="csrf-token"]');

			return {

				/* initialize flatpickr */
				init:(inputName = '.dropzone') => {
					$(inputName).each(function() {
						let elem = $(this);
						let url = elem.data('url');
		                elem.dropzone({
		                	url: url,
		                	headers: {
		                		'X-CSRF-TOKEN': token.content
		                	}
		                });
			        });
				},
			}
		}
	},
}