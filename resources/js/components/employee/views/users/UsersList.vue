<template>
    <v-data-table
        :headers="headers"
        :items="users"
        :items-per-page="5"
        class="elevation-1"
        @click:row="redirectToDetailsForm"
        :footer-props="{
            'items-per-page-text':'Ilość wyników na stronie:',
            'items-per-page-options': [5,10,15,20]
            }"
    >
        <template v-slot:item.firstname="{ item }">
            {{ getName(item.firstname) }}
        </template>
        <template v-slot:item.lastname="{ item }">
            {{ getName(item.lastname) }}
        </template>
        <template v-slot:item.company="{ item }">
            {{ getName(item.company) }}
        </template>
        <template v-slot:item.nip="{ item }">
            {{ getName(item.nip) }}
        </template>
        <template v-slot:item.phonenumber="{ item }">
            {{ formatNumber(item.phonenumber) }}
        </template>
        <template v-slot:no-data>
            <div class="px-4">Brak danych.</div>
        </template>
    </v-data-table>
</template>
<script>
import axios from "axios";
export default {
    data () {
        return {
            headers: [
                { text: 'Imię', value: 'firstname'},
                { text: 'Nazwisko', value: 'lastname'},
                { text: 'Nazwa Firmy', value: 'company'},
                { text: 'Numer NIP', value: 'nip'},
                { text: 'E-mail', value: 'email' },
                { text: 'Numer Telefonu', value: 'phonenumber' },
            ],
            nameRules: [
                v => !!v || 'To pole jest wymagane',
            ],
            users: [],
        }
    },
    methods: {
        redirectToDetailsForm(item) {
            this.$router.push({path: `/edytuj-uzytkownika/${item.id}`, params: {id: item.id}})
        },
        formatNumber(number) {
            let str = number + '';
            let formattedStr = ''
            const arr = str.match(/.{1,3}/g)
            if (arr.length) {
                arr.forEach(item => formattedStr += ' ' + item)
            }
            return formattedStr
        },
        getName(name) {
            return name ? name : '-'
        }
    },
    mounted() {
        axios.get('/api/users').
        then(res => {
            if (res.status === 200) {
                this.users = res.data.data
            }
        })
            .catch(err => console.error(err))
    },
}
</script>
<style scoped>
::v-deep tbody .text-start {
    padding: 30px 20px !important;
    min-width:8vw;
    cursor:pointer;
}
.row {
    justify-content: space-around;
}
::v-deep .v-btn {
    align-self:center;
    justify-self:flex-end;
    float:right;
}
.buttons {
    display: flex;
    justify-content: center;
}
.btn {
    background-color: #9f7f64;
    color:white;
    margin: 0 auto;
}
</style>
