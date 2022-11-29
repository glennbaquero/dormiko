Vue.mixin({

	methods:{

		numericregex:function(str) {
            return str ? str.toString().replace(/[^\d]/g,'') : str;
        },
	}
});