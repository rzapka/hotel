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
            <validation-provider
                name="name"
                rules="required"
            >
            <v-text-field
                v-model="name"
                :rules="nameRules"
                label="Nazwa"
                required
            ></v-text-field>
            </validation-provider>
            <validation-provider
                name="description"
                rules="required"
            >
            <v-textarea
                filled
                v-model="description"
                auto-grow
                label="Opis"
                rows="5"
                row-height="20"
                shaped
            ></v-textarea>
            </validation-provider>
            <validation-provider
                name="description"
                rules="required"
            >
            <v-text-field
                v-model="area"
                type="number"
                :rules="nameRules"
                label="Powierzchnia (m2)"
                required
            ></v-text-field>
            </validation-provider>
            <validation-provider
                name="price"
                rules="required"
            >
            <v-text-field
                v-model="price"
                type="number"
                :rules="nameRules"
                label="Cena"
                required
            ></v-text-field>
            </validation-provider>
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
            <div class="buttons">
                <v-btn
                    :disabled="invalid"
                    color="success"
                    class="mr-4"
                    @click="handleUpdate()"
                >
                    Dodaj
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
    },
    methods: {
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
                            this.error = null
                            this.images = this.images.concat(imagesNames)
                        }
                    })
                    .then(() =>{
                        if (!this.error) {
                            this.addRoom()
                        }
                    })
                    .catch(e => console.error(e.message))
            }
        },
        addRoom() {
            axios.post(`/api/rooms`, {
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
                this.addRoom()
            }
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
    justify-content: center;
    width:100%;
}
</style>
