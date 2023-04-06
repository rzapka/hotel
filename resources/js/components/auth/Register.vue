<template>
    <validation-observer
        ref="observer"
        v-slot="{ invalid }"
    >
        <form @submit.prevent="submit">
            <v-checkbox
                class="mb-4"
                id="company-checkbox"
                v-model="isCompany"
                label="Zarejestruj jako firma"
                color="orange darken-3"
                value="orange darken-3"
                hide-details
                @click="clear"
            ></v-checkbox>
            <validation-provider v-if="isCompany"
                v-slot="{ errors }"
                name="company"
                rules="required"
            >
                <v-text-field
                    v-model="company"
                    label="Nazwa firmy"
                    :rules="[rules.required]"
                    required
                ></v-text-field>
                <ul class="validation-message mb-3" v-if="companyErrors">
                    <li v-for="error in companyErrors">
                        <small>{{ error }}</small>
                    </li>
                </ul>
            </validation-provider>
            <validation-provider v-else
                v-slot="{ errors }"
                name="firstname"
                rules="required"
            >
                <v-text-field
                    v-model="firstname"
                    label="Imię"
                    :rules="[rules.required]"
                    required
                ></v-text-field>
                <ul class="validation-message mb-3" v-if="firstnameErrors">
                    <li v-for="error in firstnameErrors">
                        <small>{{ error }}</small>
                    </li>
                </ul>
            </validation-provider>
            <validation-provider v-if="isCompany"
                                 v-slot="{ errors }"
                                 name="nip"
                                 rules="required"
            >
                <v-text-field
                    v-model="nip"
                    type="number"
                    label="Numer NIP"
                    :rules="[rules.required]"
                    required
                ></v-text-field>
                <ul class="validation-message mb-3" v-if="nipErrors">
                    <li v-for="error in nipErrors">
                        <small>{{ error }}</small>
                    </li>
                </ul>
            </validation-provider>
            <validation-provider v-else
                v-slot="{ errors }"
                name="lastname"
                rules="required"
            >
                <v-text-field
                    v-model="lastname"
                    label="Nazwisko"
                    :rules="[rules.required]"
                    required
                ></v-text-field>
                <ul class="validation-message mb-3" v-if="lastnameErrors">
                    <li v-for="error in lastnameErrors">
                        <small>{{ error }}</small>
                    </li>
                </ul>
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="phonenumber"
                rules="required"
            >
                <v-text-field
                    v-model="phonenumber"
                    label="Numer telefonu"
                    :rules="[rules.required]"
                    required
                ></v-text-field>
                <ul class="validation-message mb-3" v-if="phonenumberErrors">
                    <li v-for="error in phonenumberErrors">
                        <small>{{ error }}</small>
                    </li>
                </ul>
            </validation-provider>
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
                <ul class="validation-message mb-3" v-if="emailErrors">
                    <li v-for="error in emailErrors">
                        <small>{{ error }}</small>
                    </li>
                </ul>
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
                <ul class="validation-message mb-3" v-if="passwordErrors">
                    <li v-for="error in passwordErrors">
                        <small>{{ error }}</small>
                    </li>
                </ul>
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="password2"
                rules="required"
            >
                <v-text-field
                    v-model="password2"
                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                    :rules="[rules.required, rules.min]"
                    :type="show1 ? 'text' : 'password'"
                    name="input-10-1"
                    label="Powtórz hasło"
                    counter
                    @click:append="show1 = !show1"
                ></v-text-field>
                <small v-if="!isMatching()" class="mb-3">Hasła muszą być jednakowe</small>
            </validation-provider>
            <div class="buttons mt-3">
                <v-btn @click="submit($event)"
                    class="mr-4"
                    type="submit"
                    :disabled="invalid || !isMatching()"
                >
                    wyślij
                </v-btn>
                <v-btn @click="clear">
                    wyczyść
                </v-btn>
            </div>
        </form>
    </validation-observer>
</template>
<script>
import { required, digits, email, max, regex } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
import axios from "axios";

setInteractionMode('eager')

extend('digits', {
    ...digits,
    message: '{_field_} needs to be {length} digits. ({_value_})',
})

extend('required', {
    ...required,
    message: '{_field_} can not be empty',
})

extend('max', {
    ...max,
    message: '{_field_} may not be greater than {length} characters',
})

extend('regex', {
    ...regex,
    message: '{_field_} {_value_} does not match {regex}',
})

extend('email', {
    ...email,
    message: 'Email must be valid',
})

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
        email: '',
        password: '',
        password2: '',
        firstname: '',
        lastname: '',
        phonenumber: '',
        company: '',
        nip: '',
        isCompany: false,
        show1: false,
        show2: true,
        show3: false,
        show4: false,
        rules: {
            required: value => !!value || 'To pole jest wymagane.',
            min: v => v.length >= 8 || 'Minimum 8 znaków',
        },
        emailRules: [
            v => !!v || 'To pole jest wymagane.',
            v => /.+@.+\..+/.test(v) || 'Nieprawidłowy format adresu e-mail',
        ],
        firstnameErrors:[],
        lastnameErrors:[],
        emailErrors:[],
        phonenumberErrors:[],
        passwordErrors:[],
        companyErrors:[],
        nipErrors:[],
    }),
    methods: {
        submit (e) {
            // this.$refs.observer.validate()\
            e.preventDefault()
            axios.get('/sanctum/csrf-cookie').then(resp => {
                axios.post('api/register', {
                    email: this.email,
                    firstname: this.firstname,
                    lastname: this.lastname,
                    company: this.company,
                    nip: this.nip,
                    phonenumber: this.phonenumber,
                    password: this.password,
                }).then(resp => {
                    if (resp.data.success) {
                        this.$router.push('/logowanie')
                    }
                }).catch(err => {
                    if (err.response.data.errors) {
                        this.firstnameErrors = err.response.data.errors.firstname
                        this.lastnameErrors = err.response.data.errors.lastname
                        this.emailErrors = err.response.data.errors.email
                        this.phonenumberErrors = err.response.data.errors.phonenumber
                        this.passwordErrors = err.response.data.errors.password
                        this.companyErrors = err.response.data.errors.company
                        this.nipErrors = err.response.data.errors.nip
                    }
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
            this.firstname = ''
            this.lastname = ''
            this.email = ''
            this.company = ''
            this.nip = ''
            this.phonenumber = ''
            this.password = ''
            this.password2 = ''
            this.$refs.observer.reset()
        },
        isMatching() {
            return this.password === this.password2
        }
    },
}
</script>
<style scoped>
::v-deep label[for="company-checkbox"]{
    left: -3px !important;
    margin-top:10px !important;
}
form {
    width: 80%;
    height:auto;
    margin: 2% auto 5%;
}
.validation-message {
    padding:0;
    list-style: none;
}
small {
    color:red;
}
</style>
