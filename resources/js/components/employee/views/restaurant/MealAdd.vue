<template>
    <div class="container">
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
        >
            <v-text-field
                v-model="name"
                :rules="nameRules"
                label="Nazwa"
                required
            ></v-text-field>

            <v-text-field
                v-model="price"
                type="number"
                :rules="nameRules"
                label="Cena"
                required
            ></v-text-field>

            <v-select
                :items="mealCategories"
                v-model="mealCategory"
                item-text="name"
                item-value="id"
                label="Wybierz kategorię"
                data-vv-name="select"
                required
            ></v-select>
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
                    Usuń posiłek
                </v-btn>
            </div>
        </v-form>
    </div>
</template>
<script>
import axios from "axios";

export default {
    props: ['id'],
    data: () => ({
        valid: true,
        name: '',
        price: '',
        mealCategories: [],
        mealCategory: false,
        nameRules: [
            v => !!v || 'To pole jest wymagane',
        ],
    }),
    mounted() {
        this.loadCategories()
    },
    methods: {
        loadCategories() {
            axios.post('/api/only-meal-categories')
                .then(resp => {
                    this.mealCategories = resp.data.data
                })
                .catch(err => console.error(err))
        },
        handleUpdate() {
            axios.post(`/api/meals`, {
                'name': this.name,
                'price': this.price,
                'meal_category_id': this.mealCategory
            }).then(res => {
                if (res.status === 200) {
                    this.$router.push({path: `/panel-pracownika`})
                }
            })
                .catch(e => console.error(e.message))
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
.image-container div img{
    height: 40vh;
    width: 30vw;
    cursor:pointer;
    border-radius:3px;
}
.image-container .image {
    margin: 2%;
    display: inline-block;
    position: relative;
}
.dim {
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute !important;
    height: 40vh;
    width:100%;
    top:0;
    left:0;
    transition: 0.2s;
}
.delete-text {
    color:white;
    visibility:hidden;
    letter-spacing: 2px;
}
.image-container,.buttons {
    display: flex;
    justify-content: center;
    align-items:center;
    flex-wrap:wrap;
}
.image-container .image:hover .dim {
    background-color: rgba(0,0,0,70%);
    z-index: 999;
    cursor:pointer;
    border-radius:3px;
}
.image-container .image:hover .dim .delete-text {
    visibility: visible;
}
.buttons {
    margin:5% auto;
    justify-content: space-evenly;
    width:60%;
}
</style>
