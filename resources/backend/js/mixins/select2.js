
/**
 * Flatpickr datepicker mixin
 *-----------------------------------------------*/

/* import css style */
import 'select2/dist/css/select2.min.css';

/* require npm package */
require('select2');

export default {

	computed:{

		/* select2 vue object */
		select2:function() {

			return {

				/* initialize select2 */
				init:(inputName = '.select2') => {

					const $this = this;

					$(inputName).each(function() {
			            const field = $(this);

			            field.select2();
			        });
				},
			}
		}
	},
}