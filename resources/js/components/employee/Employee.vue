<template>
        <v-card class="overflow-hidden">
            <v-app-bar
                absolute
                color="#6A76AB"
                dark
                shrink-on-scroll
                prominent
                src="https://i.gyazo.com/e24dfb7032a7a32822e4b5300b773d68.png"
                fade-img-on-scroll
                scroll-target="#scrolling-techniques-4"
            >
                <template v-slot:img="{ props }">
                    <v-img
                        v-bind="props"
                        gradient="to top right, rgba(100,115,201,.7), rgba(25,32,72,.7)"
                    ></v-img>
                </template>


                <v-toolbar-title class="ml-5">Witaj, {{ user.firstname }}!</v-toolbar-title>

                <v-spacer></v-spacer>

                <router-link class="router-link" :to="{name:'Notifications'}">
                <v-btn icon>
                   <v-icon class="read-heart">mdi-heart</v-icon>
                </v-btn>
                </router-link>
                <template v-slot:extension>
                    <v-tabs align-with-title>
                        <v-tab @click="setView('rooms')">Rodzaje pokojów</v-tab>
                        <v-tab @click="setView('roomNumbers')">Numery pokojów</v-tab>
                        <v-tab @click="setView('restaurant')">Restauracja</v-tab>
                        <v-tab @click="setView('attractions')">Atrakcje</v-tab>
                        <v-tab @click="setView('users')">Użytkownicy</v-tab>
                    </v-tabs>
                </template>
            </v-app-bar>
            <v-sheet
                id="scrolling-techniques-4"
                class="overflow-y-auto"

            >
                <v-container>
                    <div v-if="view === 'rooms'">
                        <RoomsList />
                    </div>
                    <div v-if="view === 'roomNumbers'">
                        <RoomNumbers />
                    </div>
                    <div v-if="view === 'restaurant'">
                        <MealsList />
                    </div>
                    <div v-if="view === 'attractions'">
                        <AttractionsList />
                    </div>
                    <div v-if="view === 'users'">
                        <UsersList />
                    </div>
                </v-container>
            </v-sheet>
        </v-card>
</template>
<script>
import RoomsList from "./views/rooms/RoomsList";
import RoomNumbers from "./views/rooms/RoomNumbers";
import MealsList from "./views/restaurant/MealsList";
import AttractionsList from "./views/attractions/AttractionsList";
import UsersList from "./views/users/UsersList";
import axios from "axios";
export default {
    components: {AttractionsList, MealsList, RoomsList, UsersList, RoomNumbers},
    data() {
        return {
            user: {firstname: 'User'},
            view: 'rooms',
            notifications: [],
            isAnyNotDisplayedNotification: false,
        }
    },
    mounted() {
        this.user = window.Laravel.user
        if ((this.user && !this.user.admin_category_id) || !window.Laravel.isLoggedIn) {
            this.$router.push('/')
        }
        this.loadNotifications()
        setInterval(() => this.loadNotifications(), 10000)
    },
    methods: {
        setView(view) {
            this.view = view
        },
        loadNotifications() {
            axios.get('/api/notifications')
                .then(resp => this.notifications = resp.data.data)
                .then(() => this.checkNotifications())
                .catch(err => console.error(err))
        },
        checkNotifications() {
            const notDisplayedNotifications = this.notifications.filter(notification => !notification.displayed)
            const item = document.querySelector('#app > div > div > header > div.v-toolbar__content > a > button > span > i')
            if (item) {
                if (notDisplayedNotifications.length > 0) {
                    item.classList.add('red-heart')
                } else {
                    item.classList.remove('red-heart')
                }
            }
        }
    }
}
</script>
<style scoped>
.container {
    margin:35vh auto;
}
#scrolling-techniques-4 {
    overflow: visible !important;
}
.router-link {
    text-decoration: none;
}
.red-heart {
    color: red !important;
}
</style>
