<template>
    <div class="wrapper">
        <v-data-table
            :headers="headers"
            :items="rooms"
            :items-per-page="5"
            class="elevation-1"
            :footer-props="{
            'items-per-page-text':'Ilość wyników na stronie:',
            'items-per-page-options': [5,10,15,20]
          }"
        >
            <template v-slot:[`footer.page-text`]="items">
                {{ items.pageStart }} - {{ items.pageStop }} na {{ items.itemsLength }}
            </template>
            <template v-slot:item.cancel="{item}">
                <v-btn v-if="checkDate(item.booked_from)" @click="deleteBook(item.id)" color="error">Anuluj</v-btn>
            </template>
            <template v-slot:no-data>
                <div class="px-4">Brak danych.</div>
            </template>
            <template v-slot:item.price="{item}">
                {{ item.price }}zł
            </template>
        </v-data-table>
    </div>
</template>
<script>
import axios from "axios";
export default {
    data () {
        return {
            headers: [
                {text: 'Pokój nr', value: 'room_number_id'},
                { text: 'Pobyt od', value: 'booked_from' },
                { text: 'Pobyt do', value: 'booked_to' },
                { text: 'Koszt pobytu', value: 'price' },
                { text: '', value: 'cancel' },
            ],
            rooms: [],
        }
    },
    methods: {
        deleteBook(id) {
            if (window.confirm('Jestes pewien ?')) {
                axios.delete('/api/reservations/delete-room/' + id)
                    .then(res => {
                        if (res.status === 200) {
                            this.rooms = this.rooms.filter(room => room.id !== id)
                        }
                    })
                    .catch(err => console.error(err))
            }
        },
        checkDate(date) {
            const today = (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)
            return today < date
        }
    },
    mounted() {
        axios.get('/api/reservations/rooms')
            .then(resp => {
                const data = resp.data.data
                if (data && data.length) {
                   this.rooms = data
                }
            })
            .catch(err => console.log(err))
    },
}
</script>
<style scoped>
::v-deep tbody .text-start {
    padding: 30px 20px !important;
    min-width:8vw;
    cursor:pointer;
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
.wrapper {
    min-height:60vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
</style>
