<template>
    <div class="container">
        <validation-observer
            ref="observer"
            v-slot="{ invalid }"
        >
            <form @submit.prevent="submit">
                <h5 class="text-center mb-5">Zarezerwuj Pobyt w SPA</h5>
                <validation-provider
                    v-slot="{ errors }"
                    name="select"
                    rules="required"
                >
                    <v-select
                              :items="employees"
                              v-model="employeeId"
                              item-value="id"
                              label="Wybierz pracownika"
                              data-vv-name="select"
                              required
                    >
                        <template v-slot:item="{item}">
                            {{ item.firstname }} {{ item.lastname }}
                        </template>
                        <template v-slot:selection="{item}">
                            {{ item.firstname }} {{ item.lastname }}
                        </template>
                    </v-select>
                </validation-provider>
                <validation-provider
                    v-slot="{ errors }"
                    name="select"
                    rules="required"
                >
                    <v-select
                        :items="getBookedDays()"
                        v-model="day"
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
import axios from "axios";
import moment from "moment";
setInteractionMode('eager')

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
        day: null,
        hour: null,
        worker: null,
        days: [],
        employeeId: [],
        hours: [
            '9:00 - 11:00',
            '11:30 - 13:30',
            '14:00 - 16:00',
            '16:30 - 18:30',
            '19:00 - 21:00',
        ],
        workers: [
            'Anna Kowalska', 'Marta Kowadło', 'Zbigniew Stonoga', 'Maria Koptyko','Izabela Łęcka'
        ],
        checkbox: null,
        rules: {
            required: value => !!value || 'Musisz coś wybrać',
        },
        employees: [],
        bookedRooms: [],
        error: false,
    }),
    mounted() {
        if (!window.Laravel.isLoggedIn) {
            this.$router.push('/logowanie')
        }
        this.isBookedRoom()
        this.loadEmployees()
        this.loadBookedRooms()
    },
    methods: {
        submit () {
            this.$refs.observer.validate()
        },
        clear () {
            this.day = null
            this.hour = null
            this.employeeId = null
        },
        isBookedRoom() {
            axios.post('/api/has-booked-room')
                .then(res => {
                    console.log(res)
                    if (!res.data) {
                        this.$router.push('/pokoje')
                    }
                })
        },
        loadEmployees() {
            axios.post('/api/get-spa-employees')
                .then(resp => {
                    if (resp.status === 200) {
                        this.employees = resp.data.data
                    }
                })
                .catch(err => console.error(err))
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
        handleSubmit() {
            axios.post('/api/booked-spa', {
                'day': this.day,
                'hours': this.hour,
                'employee': this.employeeId,
            }).then(resp => {
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
                'day': this.day,
                'hours': this.hour,
                'user_id': this.employeeId,
                'category': 'spa',
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
