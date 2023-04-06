<template>
    <div>
        <div class="buttons my-5">
            <button class="btn" @click="redirectToAddForm()">Dodaj pokój</button>
        </div>
        <v-data-table
            :headers="headers"
            :items="rooms"
            :items-per-page="5"
            class="elevation-1"
            @click:row="redirectToDetailsForm"
            :footer-props="{
            'items-per-page-text':'Ilość wyników na stronie:',
            'items-per-page-options': [5,10,15,20]
          }"
        >
            <template v-slot:[`footer.page-text`]="items">
                {{ items.pageStart }} - {{ items.pageStop }} na {{ items.itemsLength }}
            </template>
            <template v-slot:item.delete="{item}">
                <v-btn  @click="handleDelete(item.id)" color="error">Usuń</v-btn>
            </template>
            <template v-slot:no-data>
                <div class="px-4">Brak danych.</div>
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
                {text: 'Numer pokoju', value: 'id'},
                { text: 'Typ pokoju', value: 'room.name' },
                { text: 'Piętro', value: 'floor' },
                { text: '', value: 'delete' },
            ],
            rooms: [],
        }
    },
    methods: {
        handleDelete(id) {
            console.log(id)
            if (window.confirm('Jestes pewien ?')) {
                axios.delete('/api/room-numbers/' + id)
                    .then(res => {
                        if (res.status === 200) {
                            this.rooms = this.rooms.filter(room => room.id !== id)
                        }
                    })
                    .catch(err => console.error(err))
            }
        },
        redirectToAddForm() {
            this.$router.push({path: `/dodaj-nowy-pokoj`})
        }
    },
    mounted() {
        axios.get('/api/room-numbers')
            .then(resp => {
                const data = resp.data.data
                if (data && data.length) {
                    this.rooms = data
                }
            })
            .catch(err => console.error(err))
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
</style>
