<template>
    <v-timeline
        align-top
        :dense="$vuetify.breakpoint.smAndDown"
    >
        <v-timeline-item
            v-for="(item, i) in items"
            :key="i"
            :color="item.color"
            :icon="item.icon"
            fill-dot
        >
            <v-card
                :color="item.color"
                dark
            >
                <v-card-title class="text-h6">
                    {{ item.title }}
                </v-card-title>
                <v-card-text class="white text--primary pt-3">
                    <p>{{ item.description }}</p>
                    <v-btn
                        :color="item.color"
                        class="mx-0"
                        outlined
                    >
                        <router-link :style="{color: item.color}" :to="{ name: item.name}">Przejdz</router-link>
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-timeline-item>
    </v-timeline>
</template>
<script>
import axios from 'axios'
export default {
    data: () => ({
        items: [],
    }),
    mounted() {
        if (!window.Laravel.isLoggedIn) {
            this.$router.push('/logowanie')
        }
        axios.get('/api/attractions')
            .then(resp => {
                this.items = [...resp.data.data]
            })
            .catch(err => console.error(err))
    }
}

</script>
<style scoped>
a {
    color: inherit !important;
    text-decoration: none;
}
</style>
