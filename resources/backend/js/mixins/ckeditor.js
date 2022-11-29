/**
 * CKEditor datepicker mixin
 *-----------------------------------------------*/

export default {

	computed:{

		/* flatpickr vue object */
		ckeditor:function() {

			return {

				/* initialize flatpickr */
				init:(inputName = 'textarea.content') => {

					$(inputName).each(function() {
		                CKEDITOR.replace(this);
		                CKEDITOR.config.autoParagraph = false;
			        });
				},
			}
		}
	},
}