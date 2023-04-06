<template>
    <div class="container">
        <validation-observer
            ref="observer"
            v-slot="{ invalid }"
        >
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

        <v-textarea
            filled
            v-model="description"
            auto-grow
            label="Opis"
            rows="5"
            row-height="20"
            shaped
        ></v-textarea>

        <v-text-field
            v-model="area"
            type="number"
            :rules="nameRules"
            label="Powierzchnia (m2)"
            required
        ></v-text-field>

        <v-text-field
            v-model="price"
            type="number"
            :rules="nameRules"
            label="Cena"
            required
        ></v-text-field>
        <div class="mt-5 w-25 mx-auto">
            <v-file-input
                style="cursor:pointer"
                label="Dodaj nowe zdjęcie"
                truncate-length="15"
                multiple
                @change="setImages($event)"
            ></v-file-input>
        </div>
        <div v-if="error" style="color:crimson" class="mb-3 text-center" role="alert">
                {{ error }}
            </div>
        <div class="image-container">
            <div class="image" v-for="image in images" @click="deleteImage(image)">
                <img :src="require(`@/rooms/${image}`)" alt="zdjęcie">
                <div class="dim">
                    <h2 class="delete-text">Usuń</h2>
                </div>
            </div>
        </div>
        <div class="buttons">
            <v-btn
                :disabled="invalid"
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
                Usuń pokój
            </v-btn>
        </div>
    </v-form>
        </validation-observer>
    </div>
</template>
<script>
import axios from "axios";
import {ValidationObserver, ValidationProvider} from "vee-validate";

export default {
    props: ['id'],
    components: {ValidationProvider, ValidationObserver},
    data: () => ({
        valid: true,
        name: '',
        description: '',
        area: '',
        price: '',
        room: [],
        displayImages: [],
        nameRules: [
            v => !!v || 'To pole jest wymagane',
        ],
        images:[],
        newImages:[],
        error: null,
    }),
    mounted() {
        const input = document.getElementById('input-28')
            if (input) {
                input.name = 'files[]'
            }

        axios.get(`/api/rooms/${this.id}`)
            .then(resp => {
                if (resp.data.data) {
                    this.name = resp.data.data.name
                    this.description = resp.data.data.description
                    this.area = resp.data.data.area
                    this.price = resp.data.data.price
                    if (resp.data.data.images && resp.data.data.images) {
                        JSON.parse(resp.data.data.images).forEach(item => {
                            this.images.push(item)
                        })
                    }
                }
            })
            .catch(e => console.error(e.message))
    },
    methods: {
        deleteImage(image) {
            this.images = this.images.filter(item => item !== image)
        },
        setImages(images) {
            this.newImages = images
        },
        loadImages() {
            if (this.newImages.length) {
                let formData = new FormData()
                let imagesNames = []
                for (let file of this.newImages) {
                    formData.append("files[]", file, file.name);
                    imagesNames.push(file.name.toLowerCase())
                }
                axios.post('/api/upload-images', formData)
                    .then(res => {
                        if (!res.data.success) {
                            this.error = res.data.message
                        } else if (res.status === 200) {
                            this.images = this.images.concat(imagesNames)
                            this.error = null
                        }
                    })
                    .then(() => {
                        if (!this.error) {
                            this.updateRoom()
                        }
                    })
                    .catch(e => console.error(e.message))
            }
        },
        updateRoom() {
            axios.patch(`/api/rooms/${this.id}`, {
                'name': this.name,
                'description': this.description,
                'area': this.area,
                'price': this.price,
                'images': JSON.stringify(this.images),
            }).then(res => {
                if (res.status === 200) {
                    this.$router.push({path: `/panel-pracownika`})
                }
            })
                .catch(e => console.error(e.message))
        },
        handleUpdate() {
            if (this.newImages.length) {
                this.loadImages();
            } else {
                this.updateRoom()
            }
        },
        handleDelete() {
            if (confirm('Jesteś pewien?')) {
                axios.delete(`/api/rooms/${this.id}`)
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
