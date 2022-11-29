
/**
 * Flatpickr datepicker mixin
 *-----------------------------------------------*/

/* import css style */
import 'flatpickr/dist/flatpickr.min.css';

/* require npm package */
require('flatpickr');

export default {

	computed:{

		/* flatpickr vue object */
		flatpickr:function() {

			return {

				/* initialize flatpickr */
				init:(inputName = '.flatpickr', includeTime = false, timeOnly = false) => {

					const $this = this;

					let dateFormat = 'Y-m-d';

					if (includeTime) {
						dateFormat = 'Y-m-d H:i:S';
					}

					if (timeOnly) {
						dateFormat = 'H:i:S';
					}

					$(inputName).each(function() {
						/* Set default value base on the data value attr */
			            const field = $(this);
			            let date = field.val();

		            	$(this).flatpickr({
			                dateFormat: dateFormat,
							enableTime: includeTime,
							noCalendar: timeOnly,
			                onReady: function(selectedDates, dateStr, instance) {
			                	field.data('value', dateStr);
			                },
			                
			                onChange: function(selectedDates, dateStr, instance) {
			                	field.data('value', dateStr);
						    },
			            });

			        });
				},
			}
		}
	},
}