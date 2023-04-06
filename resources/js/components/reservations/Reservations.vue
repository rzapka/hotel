<template>
    <div class="container">
        <v-tabs >
            <v-tab @click="setView('room')">Pokoje</v-tab>
            <v-tab @click="setView('spa')">Spa</v-tab>
            <v-tab @click="setView('bowling')">Kręgle</v-tab>
            <v-tab @click="setView('hall')">Sala</v-tab>
        </v-tabs>

        <div v-if="view === 'room'">
            <Room />
        </div>
        <div v-if="view === 'spa'">
            <Spa />
        </div>
        <div v-if="view === 'bowling'">
            <Bowling />
        </div>
        <div v-if="view === 'hall'">
            <Hall />
        </div>
    </div>
</template>

<script>
import Room from "./Room";
import Spa from "./Spa";
import Hall from './Hall'
import Bowling from "./Bowling";
export default {
    name: "Reservations",
    components: {Bowling, Spa, Room, Hall},
    data() {
        return {
            view: 'room'
        }
    },
    methods: {
        setView(view) {
            this.view = view
        }
    }
}
</script>

<style scoped>

</style>
