<template>
	<!-- FILTERS -->
    <div class="form-group">
        <select @change="filter" class="selection-box" name="type">
            <option value="" selected>{{ defaultlabel }}</option>
            <template v-for="filter in filters">
                <option :value="filter[valuecolumn]">{{ filter[labelcolumn] }}</option>
            </template>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        filters: {},

        defaultlabel: {
            default: 'All',
            type: String,
        },

        valuecolumn: {
            default: 'id',
            type: String,
        },

        labelcolumn: {
            default: 'name',
            type: String,
        }
    },

    methods: {
        filter(event) {
            this.$emit('onfilter', event.target.value);
            console.log(event.target.value);
        },
    },
}
</script>