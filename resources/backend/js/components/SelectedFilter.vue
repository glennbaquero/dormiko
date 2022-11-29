<template>
	<!-- FILTERS -->
    <div class="form-group">
        <select @change="filter" class="selection-box" name="year">
            <option value="" selected>{{ defaultlabel }}</option>
            <template v-for="select, key in selects">
                <option :value="key+1" v-if="typeof(select) === 'string'">{{ select }}</option>
                <option :value="select" v-else>{{ select }}</option>
            </template>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        selects: {},

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
        },
    },
}
</script>