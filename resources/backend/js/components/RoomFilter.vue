<template>
	<!-- FILTERS -->
    <div class="form-group">
        <select @change="filter" class="selection-box" name="room">
            <option value="" selected>{{ defaultlabel }}</option>
            <template v-for="room in rooms">
                <option :value="room[valuecolumn]">{{ room[labelcolumn] }}</option>
            </template>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        rooms: {},
        building: {},

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