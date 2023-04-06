<template>
    <div>
        <div class="row w-100 flex-nowrap">
            <v-text-field class="col-10"
                v-model="newCategory"
                label="Dodaj nową kategorie"
                required
            ></v-text-field>
            <v-btn
                color="success"
                class="col-1"
                @click="addCategory()"
            >
                Dodaj
            </v-btn>
        </div>
        <ul class="list-group mt-3">
            <li v-for="category in categories" class="list-group-item">
                <span>{{ capitalizeFirstLetter(category.name) }}</span>
                <v-btn
                    color="error"
                    class="mr-4"
                    @click="deleteCategory(category.id)"
                >
                    Usuń
                </v-btn>
            </li>
        </ul>
        <div class="buttons my-5">
            <button class="btn" @click="redirectToAddForm()">Dodaj nowy posiłek</button>
        </div>
        <v-data-table
            :headers="headers"
            :items="meals"
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
                { text: 'Cena', value: 'price' },
                { text: 'Kategoria', value: 'meal_category.name' },
            ],
            nameRules: [
                v => !!v || 'To pole jest wymagane',
            ],
            categories:[],
            meals:[],
            newCategory: '',
        }
    },
    methods: {
        redirectToDetailsForm(item) {
            this.$router.push({path: `/edytuj-posilek/${item.id}`, params: {id: item.id}})
        },
        redirectToAddForm() {
            this.$router.push({path: `/dodaj-posilek`})
        },
        loadCategories() {
            axios.post('/api/only-meal-categories')
                .then(resp => {
                    this.categories = resp.data.data
                })
                .catch(err => console.error(err))
        },
        loadMeals() {
            axios.get('/api/meals')
                .then(resp => {
                    this.meals = resp.data.data
                })
                .catch(err => console.error(err))
        },
       capitalizeFirstLetter(string) {
            if (string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

        },
        addCategory() {
            axios.post(`/api/meal-categories`,{name:this.newCategory})
                .then(res => {
                    if (res.status === 200) {
                        this.categories.push({id: res.data.category.id, name: this.newCategory})
                        this.newCategory = ''
                    }
                })
                .catch(err => console.error(err))
        },
        deleteCategory(id) {
            if (confirm('Jesteś pewien?')) {
                axios.delete(`/api/meal-categories/${id}`)
                    .then(res => {
                        if (res.status === 200) {
                            this.categories = this.categories.filter(category => category.id !== id)
                        }
                    })
                    .catch(err => console.error(err))
            }
        }
    },
    mounted() {
        this.loadCategories()
        this.loadMeals()
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
.list-group-ite {
    /*display:flex;*/
    /*justify-content: space-around;*/
    /*align-items: space-around;*/
}
</style>
