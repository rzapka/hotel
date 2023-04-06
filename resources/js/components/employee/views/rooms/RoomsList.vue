<template>
    <div>
        <div class="buttons my-5">
            <button class="btn" @click="redirectToAddForm()">Dodaj nowy pokój</button>
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
                {
                    text: 'Nazwa',
                    align: 'start',
                    sortable: false,
                    value: 'name',
                },
                { text: 'Powierzchnia', value: 'area' },
                { text: 'Cena', value: 'price' },
                { text: 'Opis', value: 'description' },
            ],
            rooms: [],
        }
    },
    methods: {
        redirectToDetailsForm(item) {
            this.$router.push({path: `/edytuj-pokoj/${item.id}`, params: {id: item.id}})
        },
        redirectToAddForm() {
            this.$router.push({path: `/dodaj-pokoj`})
        }
    },
    mounted() {
        axios.get('/api/rooms')
            .then(resp => {
                const data = resp.data.data
                if (data && data.length) {
                    data.forEach(item => {
                        this.rooms.push({
                            id: item.id,
                            name: item.name,
                            area: item.area + 'm2',
                            price: item.price + 'zł',
                            description: item.description,
                        })
                    })
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
