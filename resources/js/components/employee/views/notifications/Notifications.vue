<template>
    <div class="container my-5">
        <v-data-table
            :headers="headers"
            :items="items"
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
            <template v-slot:item.name="{ item }">
                <span v-if="item.displayed">{{ item.name }}</span>
                <span v-else class="font-weight-bold"> {{ item.name }}</span>
            </template>
            <template v-slot:item.message="{ item }">
                <span v-if="item.displayed">{{ item.message }}</span>
                <span v-else class="font-weight-bold"> {{ item.message }}</span>
            </template>
            <template v-slot:no-data>
                <div class="px-4">Brak danych.</div>
            </template>
            <template v-slot:item.displayed="{ item }">
                <v-btn v-if="!item.displayed" @click="toggleRead(item)">
                    Oznacz jako przeczytane
                </v-btn>
                <v-btn v-else dark @click="toggleRead(item)">
                    Oznacz jako nieprzeczytane
                </v-btn>
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
                { text: 'Treść', value: 'message' },
                { text: '', value: 'displayed' },
            ],
            items: [],
        }
    },
    methods: {
        toggleRead(item) {
            axios.patch('/api/notifications/' + item.id, {
                displayed: !item.displayed
            }).then(res => {
                if (res.status === 200) {
                    item.displayed = !item.displayed
                }
            })
                .catch(err => console.error(err))
        }
    },
    mounted() {
        axios.get('/api/notifications')
            .then(resp => {
                this.items = resp.data.data
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
.container {
    display:flex;
    justify-content:center;
    align-items:center;
    min-height: 60vh;
}
.btn {
    background-color: #9f7f64;
    color:white;
    margin: 0 auto;
}
::v-deep .v-data-table__wrapper > table > tbody > tr:hover {
    background: inherit !important;
}
::v-deep .v-data-table__wrapper > table > tbody > tr td:hover {
    cursor:inherit !important;
}
</style>
