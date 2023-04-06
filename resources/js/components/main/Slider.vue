<template>
    <v-carousel :hide-delimiters="hideDelimiters">
        <v-carousel-item
            v-for="(item,i) in items"
            :key="i"
            :src="item.src"
            reverse-transition="transition"
        ></v-carousel-item>
    </v-carousel>
</template>
<script>
export default {
    props: ['items', 'hideDelimiters']
}
</script>
<style>
.v-window__next {
    right: 0;
}
</style>
