<template>
    <div class="container">
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
        >
            <v-text-field
                v-model="title"
                :rules="nameRules"
                label="Tytuł"
                required
            ></v-text-field>

            <v-textarea
                filled
                v-model="description"
                auto-grow
                label="Opis"
                rows="5"
                row-height="20"
                shaped
            ></v-textarea>
            <small>Listę ikonek znajdziesz <a href="https://pictogrammers.github.io/@mdi/font/6.9.96/">
                tutaj
            </a></small>
            <v-text-field
                v-model="icon"
                :rules="nameRules"
                label="Ikona"
                required
            ></v-text-field>

            <small style="color: #888">Wybierz kolor</small>
            <v-color-picker
                class="mt-3"
                v-model="color"
                hide-inputs
                dot-size="25"
                swatches-max-height="200"
            ></v-color-picker>
            <div class="buttons">
                <v-btn
                    :disabled="!valid"
                    color="success"
                    class="mr-4"
                    @click="handleUpdate()"
                >
                    Zatwierdź zmiany
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
        title: null,
        description: null,
        icon: null,
        color: null,
        nameRules: [
            v => !!v || 'To pole jest wymagane',
        ],
    }),
    mounted() {
        axios.get(`/api/attractions/${this.id}`)
            .then(res => {
                if (res.status === 200) {
                    this.title = res.data.data.title
                    this.description = res.data.data.description
                    this.icon = res.data.data.icon
                    this.color = res.data.data.color
                }
            })
            .catch(err => console.error(err))
    },
    methods: {
        handleUpdate() {
            axios.patch(`/api/attractions/${this.id}`, {
                'title': this.title,
                'description': this.description,
                'icon': this.icon,
                'color': this.color,
            }).then(res => {
                if (res.status === 200) {
                    this.$router.push({path: `/panel-pracownika`})
                }
            })
                .catch(e => console.error(e.message))
        },
        handleDelete() {
            if (confirm('Jesteś pewien?')) {
                axios.delete(`/api/attractions/${this.id}`)
                    .then(res => {
                        if (res.status === 200) {
                            this.$router.push({path: `/panel-pracownika`})
                        }
                    })
                    .catch(e => console.error(e.message))
            }
        }
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
