<template>
	<!-- FILTERS -->
    <div class="form-group">
        <select @change="filter" class="selection-box" name="year">
            <template v-for="selection in selections">
                <option :value="selection">{{ selection }}</option>
            </template>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        selections: {},

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