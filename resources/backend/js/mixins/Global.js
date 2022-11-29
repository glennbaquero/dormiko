import { EventBus } from '../EventBus.js'

Vue.mixin({

    data() {
        return {
            csrftoken: window.axios.defaults.headers.common['X-CSRF-TOKEN']             
        }
    },

	methods: {

        /**
         * Create a unique ID
         * 
         * @return string
         */
        getUniqueID: function(prefix) {
            let tmp = 0;
            let tmpName = prefix + '-' + tmp;

            /* Check availability */
            while(document.getElementById(tmpName)) {
                tmp++;
                tmpName = prefix + '-' + tmp;
            }
            
            return tmpName;
        },

        compareArrayValue(valueToCompare, valueToFilter, array, columnToCompare = 'value', columnToFilter = 'label') {
            let obj = array.filter((obj) => { return obj[columnToFilter] === valueToFilter })[0];
            if (!obj) { return false; }
            return obj[columnToCompare] == valueToCompare;
        },

        /**
         * Takes two objects then copies the value of the
         * first object's field value that is available
         * on the second object
         * 
         * @param  object first
         * @param  object second
         * @return object
         */
        copyObj: function(first, second) {

            /* Check if both params are objects */
            if(!this.isObject(first) || !this.isObject(second))
                return false;


            for(var prop in first) {
                if(first.hasOwnProperty(prop) && second.hasOwnProperty(prop))
                    second[prop] = first[prop];
            }

            return second;
        },

		/**
		 * Add parameters to a URL string
		 *
		 * @return string
		 */
		addURLParam: function(key, value, url) {
			var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
				hash;

			if(re.test(url)) {

				if(typeof value !== 'undefined' && value !== null) {

					return url.replace(re, '$1' + key + "=" + value + '$2$3');

				} else {

					hash = url.split('#');
					url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');

					if(typeof hash[1] !== 'undefined' && hash[1] !== null) {
						url += '#' + hash[1];
					}

					return url;
				}

			} else {

				if(typeof value !== 'undefined' && value !== null) {

					var separator = url.indexOf('?') !== -1 ? '&' : '?';

					hash = url.split('#');
					url = hash[0] + separator + key + '=' + value;

					if(typeof hash[1] !== 'undefined' && hash[1] !== null) {
						url += '#' + hash[1];
					}

					return url;

				} else {
					return url;
				}
			}
		},


        /**
         * ==================================================================================
         * @Helpers
         * ==================================================================================
         **/

         formSubmit(event) {
            let form = event.target;
            let ref = form.dataset.ref;

            if (ref) {
                ref = this.$refs[ref];
                if (ref.loading) { return; }
                ref.load(true);
            }


            let data = new FormData(form);
            let method = form.dataset.method;
            let url = form.dataset.action;

            try {
                let ckeditor = CKEDITOR.instances;

                if (ckeditor) {
                    for (var key in ckeditor) {
                        if (ckeditor.hasOwnProperty(key)) {
                            data.append(key, ckeditor[key].getData());
                        }
                    }
                }
            } catch(e) {
                console.log(e);
            }

            if (!method) {
                method = 'post';
            }

            axios[method](url, data)
            .then(response => {
                this.alert(response);

                if (ref) {
                    ref.init();
                }
            }).catch(error => {
                this.showErrors(error);
            }).then(() => {
                if (ref) {
                    ref.load(false);
                }
            });
        },

        alert(response) {
            const data = response.data;

            let message = data.message;
            let title = data.title;
            let type = data.type;
            let list = data.list;

            if (!title) {
                title = 'Succes';
            }

            if (!message) {
                message = 'Action has been successful!';
            }

            if (!type) {
                type = 'success';
            }

            if (!list) {
                list = [];
            }


            EventBus.$emit('showModal', {
                                content: message,
                                type: 'success',
                                list: list,
                            });

            if (data.redirect) {
                window.location.href = data.redirect;
            }
        },
        /**
         * Check if param is String
         * 
         * @param  value
         * @return boolean
         */
        isString:function(value) {
            return typeof value === 'string' || value instanceof String;
        },

        /**
         * Check if param is Array
         * 
         * @param  value
         * @return boolean
         */
        isArray:function(value) {
            return value && typeof value === 'object' && value.constructor === Array;
        },

        /**
         * Check if param is Object
         * 
         * @param  obj
         * @return boolean
         */
        isObject: function(obj) {
            return obj === Object(obj);
        },

        /**
         * Validate if a value exists on an array
         * 
         * @param  mixed
         * @param  array
         * @return boolean
         */
        isInArray: function(value, array) {

            console.log(value);
            console.log(array);

            var result = false;

            array.forEach(arr => {

                if(this.isArray(value)) {
                    
                    value.forEach(val => {

                        console.log(arr === val);

                        if(arr === val) {
                            result = true;
                        }
                    });

                } else {

                    if(arr === value) {
                        result = true;
                    }
                }
            });

            return result;
        },

        showErrors(error) {
            const response = error.response;

            console.log(response);
            
            if(response.status) {
               switch (response.status) {
                    case 422:
                            EventBus.$emit('showModal', {
                                content: response.data.errors,
                                type: 'danger'
                            });
                        break;
                    default:
                            EventBus.$emit('showModal', {
                                content: response.data ? response.data.message : response.statusText,
                                hasErrors: true,
                            });
                        break;
                } 
            } else {
                console.log(error)
            }
            
        },
        
        showModal(title = null) {
            ebi.$emit('showModal', {
                title: title,
            })
        },
	}
});