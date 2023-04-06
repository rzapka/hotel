<template>
    <div class="container">
        <validation-observer
            ref="observer"
            v-slot="{ invalid }"
        >
            <div v-if="error" style="color:crimson" class="mb-3 text-center" role="alert">
                {{ error }}
            </div>
            <v-form
                ref="form"
                v-model="valid"
                lazy-validation
            >
                <validation-provider
                    name="id"
                    rules="required"
                >
                    <v-text-field
                        v-model="id"
                        type="number"
                        :rules="nameRules"
                        label="Numer pokoju"
                        required
                    ></v-text-field>
                </validation-provider>
                <validation-provider
                    name="roomType"
                    rules="required"
                >
                    <v-select
                        v-model="roomType"
                        :items="rooms"
                        item-text="name"
                        item-value="id"
                        label="Typ pokoju"
                        data-vv-name="select"
                        required
                    ></v-select>
                </validation-provider>
                <validation-provider
                    name="floor"
                    rules="required"
                >
                    <v-text-field
                        v-model="floor"
                        type="number"
                        :rules="nameRules"
                        label="Piętro"
                        required
                    ></v-text-field>
                </validation-provider>
                <div class="buttons">
                    <v-btn
                        :disabled="invalid"
                        color="success"
                        class="mr-4"
                        @click="addRoom()"
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
        id: null,
        roomType: null,
        floor: null,
        nameRules: [
            v => !!v || 'To pole jest wymagane',
        ],
        rooms: [],
        error: null,
    }),
    mounted() {
        axios.get('/api/rooms')
            .then(resp => {
                const data = resp.data.data
                if (data && data.length) {
                    this.rooms = data
                }
            })
            .catch(err => console.error(err))
    },
    methods: {
        addRoom() {
            axios.post(`/api/room-numbers`, {
                'id': this.id,
                'room_id': this.roomType,
                'floor': this.floor,
            }).then(res => {
                if (!res.data.success) {
                    this.error = res.data.message
                }else if (res.data.success) {
                    this.error = null
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
    justify-content: center;
    width:100%;
}
</style>
