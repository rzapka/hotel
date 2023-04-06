<template>
        <v-data-table
            :headers="headers"
            :items="attractions"
            :items-per-page="5"
            class="elevation-1"
            @click:row="redirectToDetailsForm"
            :footer-props="{
            'items-per-page-text':'Ilość wyników na stronie:',
            'items-per-page-options': [5,10,15,20]
            }"
        >
            <template v-slot:item.color="{ item }">
                <div class="dot" :style="{'backgroundColor': item.color}"></div>
            </template>
            <template v-slot:no-data>
                <div class="px-4">Brak danych.</div>
            </template>
            <template v-slot:item.icon="{ item }">
                <span :class="'mdi '+item.icon"></span>
            </template>
            <template v-slot:[`footer.page-text`]="items">
                {{ items.pageStart }} - {{ items.pageStop }} na {{ items.itemsLength }}
            </template>
        </v-data-table>
</template>
<script>
import axios from "axios";
export default {
    data () {
        return {
            headers: [
                {
                    text: 'Tytuł',
                    align: 'start',
                    sortable: false,
                    value: 'title',
                },
                { text: 'Opis', value: 'description' },
                { text: 'Kolor', value: 'color' },
                { text: 'Ikona', value: 'icon' },
            ],
            nameRules: [
                v => !!v || 'To pole jest wymagane',
            ],
            attractions: [],
        }
    },
    methods: {
        redirectToDetailsForm(item) {
            this.$router.push({path: `/edytuj-atrakcje/${item.id}`, params: {id: item.id}})
        },
        capitalizeFirstLetter(string) {
            if (string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

        },
    },
    mounted() {
        axios.get('/api/attractions').
            then(res => {
                if (res.status === 200) {
                    this.attractions = res.data.data
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
.dot {
    height:3vh !important;
    width:3vh !important;
    border-radius:50% !important;
}
</style>
