<template>
    <div class="container">
        <h5 class="d-inline">Zarezerwuj</h5><h4 class="ml-2 text-uppercase"> {{ name }}</h4>
        <validation-observer
            ref="observer"
            v-slot="{ invalid }"
        >
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
        >
            <Calendar @getDate="setDate"/>
            <span v-if="error" class="my-5 d-block" role="alert" style="color:crimson">
                {{ error }}
            </span>
            <validation-provider
                name="quantity"
                rules="required"
            >
            <v-text-field
                @change="getAvailableRooms()"
                v-model="quantity"
                :rules="rules"
                label="Podaj liczbę dni"
                type="number"
                required
            ></v-text-field>
                </validation-provider>
            <validation-provider
                name="selectedRoom"
                rules="required"
            >
            <v-select v-if="availableRooms.length"
                :items="availableRooms"
                v-model="selectedRoom"
                item-value="id"
                label="Wybierz pokój"
                data-vv-name="select"
                required
            >
                <template v-slot:item="{item}">
                    Pokój numer {{item.number}} - ({{item.floor}} piętro)
                </template>
                <template v-slot:selection="{item}">
                    Pokój numer {{item.number}} - ({{item.floor}} piętro)
                </template>
            </v-select>
                </validation-provider>
            <p v-if="selectedRoom && quantity">
                Rezerwacja pokoju od <span class="font-weight-bold">{{ startingDate.split('-').reverse().join('.') }}</span> do <span class="font-weight-bold">{{ getEndDate().split('-').reverse().join('.') }}.</span> Koszt pobytu: <span class="font-weight-bold">{{ getTotalPrice() }}zł</span>
            </p>
            <div class="buttons">
                <v-btn
                    :disabled="invalid || !selectedRoom"
                    class="mr-4"
                    @click="handleSubmit"
                >
                    Zatwierdź zmiany
                </v-btn>
            </div>
        </v-form>
        </validation-observer>
    </div>
</template>
<script>
import axios from "axios";
import Calendar from "../widgets/Calendar";
import {ValidationObserver, ValidationProvider} from "vee-validate";
import moment from "moment";
export default {
    components: {Calendar, ValidationProvider, ValidationObserver},
    props: ['id'],
    data: () => ({
        valid: true,
        quantity: null,
        name: null,
        price: null,
        rules: {
            required: value => !!value || 'To pole jest wymagane.',
        },
        startingDate: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        availableRooms: [],
        selectedRoom: null,
        error: null,
    }),
    mounted() {
        if (!window.Laravel.isLoggedIn) {
            this.$router.push('/logowanie')
        }
        this.getRoom()
    },
    methods: {
        getRoom() {
            axios.get(`/api/rooms/${this.id}`)
                .then(resp => {
                    if (resp.data.data) {
                        this.name = resp.data.data.name
                        this.price = resp.data.data.price
                    }
                })
                .catch(e => console.error(e.message))
        },
        setDate(value) {
            this.startingDate = value
        },
        getAvailableRooms() {
            axios.post('/api/available-rooms',{
                startingDate: this.startingDate,
                quantity: this.quantity,
                id: this.id
            }).then(res => {
                if (res.status === 200) {
                    this.availableRooms = res.data
                }
            })
        },
        getEndDate() {
            return moment(this.startingDate, "YYYY-MM-DD").add(this.quantity, 'days').format('YYYY-MM-DD')
        },

        getTotalPrice() {
            return this.price * this.quantity
        },
        handleSubmit() {
            axios.post('/api/booked-rooms', {
                startingDate: this.startingDate,
                quantity: this.quantity,
                price: this.getTotalPrice(),
                roomNumber: this.selectedRoom
            }).then(res => {
                if (res.data.success === false) {
                    this.error = res.data.message
                }
                else if (res.status === 200) {
                    this.createNotification(this.startingDate)
                    this.$router.push('/atrakcje')
                } else {
                    this.error = 'Coś poszło nie tak. Skontaktuj się z administratorem.'
                }
            }).catch(err => console.error(err))
        },
        createNotification(startingDate) {
            axios.post('/api/notifications', {
                startingDate: startingDate,
                quantity: this.quantity,
                roomNumber: this.selectedRoom,
                category: 'room'
            }).catch(err => console.error(err))
        },
    },
}
</script>
<style scoped>
.container {
    min-height: 80vh;
}

.buttons {
    display: flex;
    justify-content: center;
    align-items:center;
    flex-wrap:wrap;
}

.buttons {
    margin:5% auto;
    justify-content: space-evenly;
    width:60%;
}
h4 {
    margin-top:2%;
    margin-bottom:5%;
    color: #66BB6A;
    display: inline-block;
}
</style>
