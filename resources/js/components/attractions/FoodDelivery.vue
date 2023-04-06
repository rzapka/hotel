<template>
    <div class="container">
        <validation-observer
            ref="observer"
            v-slot="{ invalid }"
        >
            <form @submit.prevent="submit">
                <h5 class="text-center mb-5">Zamów jedzenie</h5>
                <span v-if="error" class="invalid-data-message mb-3" role="alert">
                    {{ error }}
                </span>
                <validation-provider
                    v-slot="{ errors }"
                    name="room"
                    rules="required"
                >
                    <v-select
                        v-model="room"
                        :items="rooms"
                        :rules="[rules.required]"
                        item-text="room_number_id"
                        item-value="room_number_id"
                        label="Wybierz numer pokoju"
                        data-vv-name="select"
                        required
                    ></v-select>
                </validation-provider>
                <v-textarea
                    filled
                    v-model="description"
                    auto-grow
                    label="Opis"
                    rows="5"
                    row-height="20"
                    shaped
                ></v-textarea>
                <div class="row">
                <div class="my-5 summary py-5">
                    <ul>
                        <li class="row" v-for="meal in order">
                            <p class="col-8">{{ meal.name }} - {{ meal.price }}zł</p>
                            <button class="btn btn-danger col-1 mb-3" @click="deleteFromOrder(meal)"><span>-</span>
                            </button>
                        </li>
                    </ul>
                    <div class="total">
                        <p class="text-right">Suma: {{ total }}zł</p>
                    </div>
                </div>
                    <v-btn
                        class="align-self-center ml-5"
                        color="success"
                        type="submit"
                        :disabled="invalid"
                        @click="handleSubmit"
                    >
                        wyślij
                    </v-btn>
                </div>
                <section v-for='item in menu' class="mx-auto" :key="item.id" :id="item.name">
                    <h3 class="text-uppercase text-secondary font-italic my-5">
                        {{ item.name }}
                    </h3>
                    <ul class="meals">
                        <li v-for="meal in item.meals" :key="meal.id">
                            <div class="list-container row my-2">
                                <p class="col-5">{{ meal.name }}</p>
                                <p class="col-5">{{ meal.price }} zł</p>
                                <button class="btn btn-success add-meal mt-2" @click="addToOrder(meal)"><span>+</span></button>
                            </div>
                        </li>
                    </ul>
                </section>
            </form>
        </validation-observer>
    </div>
</template>
<script>
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
import axios from "axios";

setInteractionMode('eager')

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
        menu: [],
        room: null,
        rooms: [],
        description: null,
        order: [],
        checkbox: null,
        total: 0,
        error: '',
        rules: {
            required: value => !!value || 'Musisz coś wybrać',
            requiredNumber: value => !!value || 'Musisz coś wpisać',
        }
    }),
    mounted() {
        if (!window.Laravel.isLoggedIn) {
            this.$router.push('/logowanie')
        }
        this.loadMenu()
        this.loadAvailableRooms()
    },
    methods: {
        submit () {
            this.$refs.observer.validate()
        },
        clear () {
            this.menu = null
            this.room = null
        },
        loadMenu() {
            axios.get('/api/meal-categories')
                .then(resp => {
                    this.menu = resp.data.data
                })
                .catch(err => console.error(err))
        },
        loadAvailableRooms() {
            axios.post('/api/get-user-booked-rooms')
                .then(res => {
                    this.rooms = res.data
                    if (!this.rooms.length) {
                        this.$router.push('/pokoje')
                    }
                })
                .catch(err => console.error(err))
        },
        addToOrder(meal) {
            this.order.push(meal)
            this.total += meal.price
        },
        deleteFromOrder(meal) {
            this.order = this.order.filter(item => item.id !== meal.id)
            this.total -= meal.price
        },
        handleSubmit() {
            axios.post('/api/food-orders', {
                room: this.room,
                price: this.total,
                description: this.description,
                meals: JSON.stringify(this.order),
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
                room: this.room,
                price: this.total,
                description: this.description,
                category: 'foodDelivery',
                meals: JSON.stringify(this.order)
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
.meals {
    padding-left:0;
    list-style:none;
}
#pills-home-tab.active {
    background-color: #c5b09e;
    border-radius: 0;
    color: #fff;
}
.add-meal {
    position:relative;
    height: 30px;
}
.add-meal span {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
section {
    width:80%;
}
.summary {
    position: relative;
    width:60%;
    min-height:10vh;
    border:2px solid #aaa;
    border-radius:5px;
}
.total {
    position: absolute;
    right: 5%;
    bottom: 0;
}
ul {
    list-style: none;
}
.btn.btn-danger {
    position:relative;
    float:right;
    height:20px;
    align-self: center;
}

.btn.btn-danger span {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.summary ul li {
    width:40%;
}
.invalid-data-message {
    color:crimson;
}
</style>
