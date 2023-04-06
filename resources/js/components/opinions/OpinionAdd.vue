<template>
    <div class="container">
        <validation-observer
            ref="observer"
            v-slot="{ invalid }"
        >
            <v-form
                ref="form"
                v-model="valid"
                lazy-validation
            >
                <span v-if="error" class="my-5 d-block" role="alert" style="color:crimson">
                {{ error }}
                </span>
                <validation-provider
                    name="message"
                    rules="required"
                >
                    <v-textarea
                        filled
                        v-model="message"
                        auto-grow
                        label="Opis"
                        rows="5"
                        row-height="20"
                        shaped
                    ></v-textarea>
                </validation-provider>
                    <div class="stars text-center">
                        <span  v-for="n in 5" @click="addNote(n)" class="mdi mdi-star"></span>
                    </div>
                <div class="buttons">
                    <v-btn
                        :disabled="invalid || !stars"
                        color="success"
                        class="mr-4"
                        @click="handleSubmit"
                    >
                        Dodaj opinie
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
    components: {ValidationProvider, ValidationObserver},
    data: () => ({
        valid: true,
        rules: {
            required: value => !!value || 'To pole jest wymagane.',
        },
        message: null,
        error: null,
        stars: 0,
        isOpinion: false,
    }),
    mounted() {
        if (!window.Laravel.isLoggedIn) {
            this.$router.push('/')
        }
        this.isUserOpinion()
        if (this.isOpinion) {
            this.$router.push('/opinie')
        }
    },
    methods: {
        addNote(n) {
            const allStars = document.querySelectorAll('.mdi-star')
            this.stars = 6 - n

            for (let i = 0; i < 5; i++) {
                allStars[i].style.color = 'black'
            }
            for (let i = 4; i + 1 >= n; i--) {
                allStars[i].style.color = 'goldenrod'
            }
        },
        handleSubmit() {
            axios.post('/api/opinions', {
                message: this.message,
                stars: this.stars
            }).then(res => {
                if (res.status === 200) {
                    this.$router.push('/opinie')
                }
            })
                .catch(err => console.error(err))
        },
        isUserOpinion() {
            axios.post('/api/is-user-opinion')
                .then(resp => {
                    this.isOpinion = resp.data.isUserOpinion
                })
                .catch(err => console.error(err))
        }

    },
}
</script>
<style scoped>
.container {
    margin-top:5%;
    min-height: 55vh;
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
.stars {
    direction: rtl;
}
.mdi-star {
    font-size: 30px;
    cursor:pointer;
    transition: 0.3s all;
}
.mdi-star:hover, .mdi-star:hover ~ span {
    color: goldenrod;
}
</style>
