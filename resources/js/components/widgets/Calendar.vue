<template>
    <v-row justify="center">
        <v-date-picker locale="pl" v-model="picker" color="green lighten-1" @change="handleChange"></v-date-picker>
    </v-row>
</template>
<script>
export default {
    data () {
        return {
            picker: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        }
    },
    methods: {
        handleChange () {
            this.$emit('getDate', this.picker)
        }
    }
}
</script>
