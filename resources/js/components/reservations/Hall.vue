<template>
    <div class="wrapper">
        <v-data-table
            :headers="headers"
            :items="hall"
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
            <template v-slot:no-data>
                <div class="px-4">Brak danych.</div>
            </template>
            <template v-slot:item.cancel="{item}">
                <v-btn v-if="checkDate(item.day)" @click="deleteBook(item.id)" color="error">Anuluj</v-btn>
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
                { text: 'Godziny', value: 'hours' },
                { text: 'Dzień', value: 'day' },
                { text: '', value: 'cancel' },
            ],
            hall: [],
        }
    },
    methods: {
        deleteBook(id) {
            if (window.confirm('Jestes pewien ?')) {
                axios.delete('/api/reservations/delete-hall/' + id)
                    .then(res => {
                        if (res.status === 200) {
                            this.hall = this.hall.filter(item => item.id !== id)
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
        axios.get('/api/reservations/hall')
            .then(resp => {
                const data = resp.data.data
                if (data && data.length) {
                    this.hall = data
                }
            })
            .catch(err => console.log(err))
    }
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
