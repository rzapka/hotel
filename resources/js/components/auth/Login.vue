<template>
    <validation-observer
        ref="observer"
        v-slot="{ invalid }"
    >
        <form @submit.prevent="submit">
            <span v-if="error" class="invalid-data-message mb-3" role="alert">
                {{ error }}
            </span>
            <validation-provider
                v-slot="{ errors }"
                name="email"
                rules="required|email"
            >
                <v-text-field
                    v-model="email"
                    label="E-mail"
                    :rules="emailRules"
                    required
                ></v-text-field>
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="password"
                rules="required"
            >
                <v-text-field
                    v-model="password"
                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                    :rules="[rules.required, rules.min]"
                    :type="show1 ? 'text' : 'password'"
                    name="input-10-1"
                    label="Hasło"
                    hint="Minimum 8 znaków"
                    counter
                    @click:append="show1 = !show1"
                ></v-text-field>
            </validation-provider>
            <div class="buttons mt-3">
                <v-btn
                    class="mr-4"
                    type="submit"
                    :disabled="invalid"
                >
                    wyślij
                </v-btn>
                <v-btn @click="clear">
                    wyczyść
                </v-btn>
                <span class="float-right">
                    Nie masz jeszcze konta?
                    <router-link :to="{name: 'Register'}">
                        Zarejestruj się tutaj!
                    </router-link>
                </span>
            </div>
        </form>
    </validation-observer>
</template>
<script>
import { required, digits, email, max, regex } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
import axios from 'axios'

setInteractionMode('eager')

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
        email: '',
        password: '',
        items: [
            'Item 1',
            'Item 2',
            'Item 3',
            'Item 4',
        ],
        show1: false,
        show2: true,
        show3: false,
        show4: false,
        rules: {
            required: value => !!value || 'To pole jest wymagane.',
            min: v => v.length >= 8 || 'Minimum 8 znaków',
            emailMatch: () => (`E-mail i hasło nieprawidłowe`),
        },
        error: '',
        emailRules: [
            v => !!v || 'To pole jest wymagane.',
            v => /.+@.+\..+/.test(v) || 'Nieprawidłowy format adresu e-mail',
        ],
    }),
    mounted() {
        if (window.Laravel.isLoggedIn) {
            this.$router.push('/')
        }
    },
    methods: {
        submit (e) {
            e.preventDefault()
            axios.get('/sanctum/csrf-cookie').then(resp => {
                axios.post('api/login', {
                    email: this.email,
                    password: this.password,
                }).then(resp => {
                    if (resp.data.success) {
                        location.reload()
                    } else {
                        this.error = resp.data.message
                    }
                }).catch(err => {
                    this.error = 'Coś poszło nie tak. Skontaktuj się z administratorem.'
                    console.error(err)
                })
            })
        },
        beforeRouteEnter(to, from, next) {
            if (window.Laravel.isLoggedIn) {
                return next('/')
            }
            next()
        },
        clear () {
            this.email = ''
            this.password = ''
            this.$refs.observer.reset()
        },
    },
}
</script>
<style scoped>
form {
    display:flex;
    flex-direction:column;
    justify-content: center;
    width: 80%;
    height:55vh;
    margin: 0 auto 4%;
}
.v-messages .theme--light .error--text, .invalid-data-message {
    color:crimson;
}
</style>
