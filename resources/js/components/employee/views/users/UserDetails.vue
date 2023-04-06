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
            <validation-provider v-if="isCompany"
                name="company"
                rules="required"
            >
                <v-text-field
                    v-model="company"
                    :rules="[rules.required]"
                    label="Nazwa Firmy"
                    required
                ></v-text-field>
            </validation-provider>
            <validation-provider v-else
                name="firstname"
                rules="required"
            >
            <v-text-field
                v-model="firstname"
                :rules="[rules.required]"
                label="Imię"
                required
            ></v-text-field>
            </validation-provider>
            <validation-provider  v-if="isCompany"
                name="lastname"
                rules="required"
            >
                <v-text-field
                    v-model="nip"
                    :rules="[rules.required]"
                    label="Numer NIP"
                    required
                    type="number"
                ></v-text-field>
            </validation-provider>
            <validation-provider v-else
                name="lastname"
                rules="required"
            >
                <v-text-field
                    v-model="lastname"
                    :rules="[rules.required]"
                    label="Nazwisko"
                    required
                ></v-text-field>
            </validation-provider>

            <validation-provider
                name="email"
                rules="required"
            >
                <v-text-field
                    v-model="email"
                    :rules="emailRules"
                    label="E-mail"
                    required
                ></v-text-field>
            </validation-provider>

            <validation-provider
                name="phonenumber"
                rules="required"
            >
                <v-text-field
                    v-model="phonenumber"
                    type="number"
                    :rules="[rules.required]"
                    label="Numer Telefonu"
                    required
                ></v-text-field>
            </validation-provider>

            <validation-provider
                name="password"
                rules="required"
            >
                <v-text-field
                    v-model="password"
                    label="Ustaw nowe hasło (opcjonalne)"
                    required
                ></v-text-field>
            </validation-provider>


            <div class="buttons">
                <v-btn
                    :disabled="!valid"
                    color="success"
                    class="mr-4"
                    @click="handleUpdate()"
                >
                    Zatwierdź zmiany
                </v-btn>
                <v-btn
                    color="error"
                    class="mr-4"
                    @click="handleDelete()"
                >
                    Usuń Użytkownika
                </v-btn>
            </div>
            </v-form>
        </validation-observer>
    </div>
</template>
<script>
import axios from "axios";
import {ValidationObserver, ValidationProvider} from "vee-validate";

export default {
    props: ['id'],
    components: {ValidationProvider, ValidationObserver},
    data: () => ({
        valid: true,
        firstname: null,
        lastname: null,
        email: null,
        phonenumber: null,
        password: null,
        nip: null,
        company: null,
        isCompany: false,
        rules: {
            required: value => !!value || 'To pole jest wymagane.',
            min: v => v.length >= 8 || 'Minimum 8 znaków',
        },
        emailRules: [
            v => !!v || 'To pole jest wymagane.',
            v => /.+@.+\..+/.test(v) || 'Nieprawidłowy format adresu e-mail',
        ],
    }),
    mounted() {
        axios.get(`/api/users/${this.id}`)
            .then(res => {
                if (res.status === 200) {
                    this.firstname = res.data.data.firstname
                    this.lastname = res.data.data.lastname
                    this.nip = res.data.data.nip
                    this.company = res.data.data.company
                    this.phonenumber = res.data.data.phonenumber
                    this.email = res.data.data.email
                    this.isCompany = res.data.data.isCompany
                }
            })
            .catch(err => console.error(err))
    },
    methods: {
        handleUpdate() {
            axios.patch(`/api/users/${this.id}`, {
                'firstname': this.firstname,
                'lastname': this.lastname,
                'phonenumber': this.phonenumber,
                'company': this.company,
                'nip': this.nip,
                'email': this.email,
                'password': this.password,
            }).then(res => {
                if (res.status === 200) {
                    this.$router.push({path: `/panel-pracownika`})
                }
            })
                .catch(e => console.error(e.message))
        },
        handleDelete() {
            if (confirm('Jesteś pewien?')) {
                axios.delete(`/api/users/${this.id}`)
                    .then(res => {
                        if (res.status === 200) {
                            this.$router.push({path: `/panel-pracownika`})
                        }
                    })
                    .catch(e => console.error(e.message))
            }
        },
    },
}
</script>
<style scoped>
.container {
    padding-top:5%;
    min-height: 80vh;
}
::v-deep #input-19 {
    padding-top:2% !important;
}
::v-deep .v-input__slot {
    cursor:pointer !important;
}
.delete-text {
    color:white;
    visibility:hidden;
    letter-spacing: 2px;
}
.buttons {
    margin:5% auto;
    justify-content: space-evenly;
    width:60%;
}
</style>
