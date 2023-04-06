<template>
    <v-footer
        dark
        padless
    >
        <v-card
            flat
            tile
            class="#c5b09e lighten-1 white--text text-center"
        >
            <v-card-text>
                <v-btn
                    v-for="icon in icons"
                    :key="icon"
                    class="mx-4 white--text"
                    icon
                >
                    <v-icon size="24px">
                        {{ icon }}
                    </v-icon>
                </v-btn>
            </v-card-text>

            <v-card-text class="white--text pt-0 mt-5">
                Nasz hotel sprawi, że spełnią się twoje najskrytsze marzenia.
                <br>
                Zapraszamy na nasze media społecznościowe
            </v-card-text>

            <v-divider></v-divider>

            <v-card-text class="white--text">
                {{ new Date().getFullYear() }} — <strong>Hotel</strong>
            </v-card-text>
        </v-card>
    </v-footer>
</template>
<script>
export default {
    data: () => ({
        icons: [
            'mdi-facebook',
            'mdi-twitter',
            'mdi-linkedin',
            'mdi-instagram',
        ],
    }),
}
</script>
<style>
#app > div > div > footer > div, #app > div > footer > div {
    background-color: #c5b09e;
}
#app > div > footer > div {
    width: 100% !important;
    min-height:30vh !important;
}
</style>
