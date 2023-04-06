<template>
    <div class="container">
        <validation-observer
            ref="observer"
            v-slot="{ invalid }"
        >
            <form @submit.prevent="submit">
                <h5 class="text-center mb-5">Zarezerwuj salę</h5>
                <validation-provider
                    v-slot="{ errors }"
                    name="select"
                    rules="required"
                >
                    <v-select
                        v-model="day"
                        :rules="[rules.required]"
                        :items="getBookedDays()"
                        label="Wybierz dzień"
                        data-vv-name="select"
                        required
                    >
                        <template v-slot:item="{item}">
                            {{ item.split('-').reverse().join('.') }}
                        </template>
                        <template v-slot:selection="{item}">
                            {{ item.split('-').reverse().join('.') }}
                        </template>
                    </v-select>
                </validation-provider>
                <validation-provider
                    v-slot="{ errors }"
                    name="select"
                    rules="required"
                >
                    <v-select
                        v-model="hour"
                        :items="hours"
                        :rules="[rules.required]"
                        label="Wybierz przedział godzinowy"
                        data-vv-name="select"
                        required
                    ></v-select>
                </validation-provider>
                <span v-if="error" class="invalid-data-message mb-3" role="alert">
                    {{ error }}
                </span>
                <div class="mt-5">
                    <v-btn
                        class="mr-4"
                        type="submit"
                        :disabled="invalid"
                        @click="handleSubmit"
                    >
                        wyślij
                    </v-btn>
                    <v-btn @click="clear">
                        wyczyść
                    </v-btn>
                </div>
            </form>
        </validation-observer>
    </div>
</template>
<script>
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
import moment from "moment";
import axios from "axios";

setInteractionMode('eager')

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
        day: null,
        hour: null,
        bookedRooms: [],
        error: false,
        days: [],
        hours: [
            '9:00 - 11:00',
            '11:30 - 13:30',
            '14:00 - 16:00',
            '16:30 - 18:30',
            '19:00 - 21:00',
        ],
        checkbox: null,
        rules: {
            required: value => !!value || 'Musisz coś wybrać',
        }
    }),
    mounted() {
        if (!window.Laravel.isLoggedIn) {
            this.$router.push('/logowanie')
        }
        this.isBookedRoom()
        this.loadBookedRooms()
    },
    methods: {
        submit () {
            this.$refs.observer.validate()
        },
        clear () {
            this.day = null
            this.hour = null
        },
        isBookedRoom() {
            axios.post('/api/has-booked-room')
                .then(res => {
                    if (!res.data) {
                        this.$router.push('/pokoje')
                    }
                }).catch(err => console.error(err))
        },
        getBookedDays() {
            let arr = []
            this.bookedRooms.forEach(item => {
                const days = this.getDaysArray(item.booked_from, item.booked_to)
                days.forEach(day => arr.push(day))
            })
            return [...new Set(arr)]
        },
        getDaysArray(startDate, stopDate) {
            let dateArray = [];
            let currentDate = moment(startDate);
            stopDate = moment(stopDate);
            const today = moment(new Date().toISOString().slice(0, 10))
            while (currentDate <= stopDate) {
                if (currentDate >= today) {
                    dateArray.push( moment(currentDate).format('YYYY-MM-DD') )
                }
                currentDate = moment(currentDate).add(1, 'days');
            }
            return dateArray
        },
        loadBookedRooms() {
            axios.get('/api/booked-rooms')
                .then(resp => {
                    if (resp.status === 200) {
                        this.bookedRooms = resp.data.data
                    }
                })
                .catch(err => console.error(err))
        },
        handleSubmit() {
            axios.post('/api/booked-hall', {
                hours: this.hour,
                day: this.day,
            })
                .then(resp => {
                    if (!resp.data.success) {
                        this.error = resp.data.message
                    } else if (resp.status === 200) {
                        this.createNotification()
                        this.$router.push('/atrakcje')
                    }
                })
                .catch(err => console.error(err))
        },
        createNotification() {
            axios.post('/api/notifications', {
                hours: this.hour,
                day: this.day,
                category: 'hall'
            }).catch(err => console.error(err))
        },
    },
}
</script>
<style scoped>
form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height:60vh !important;
}
h5 {
    color: #c09977;
}
.invalid-data-message {
    color:crimson;
}
</style>
