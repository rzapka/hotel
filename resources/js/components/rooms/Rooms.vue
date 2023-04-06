<template>
    <div class="wrapper py-3">
        <div v-for="room in rooms" class="my-5 room-section py-5">
            <Slider :items="getImages(room.images)"/>
            <div class="room-caption px-5 pt-4 py-2">
                <h4 class="text-uppercase font-italic">{{ room.name }}</h4>
                <h4 class="text-uppercase">{{ room.price }} <h6 class="d-inline"> zł / noc</h6></h4>
            </div>
            <div class="features mt-4">
               <h6 class="mr-4"><span class="mdi mdi-border-radius mr-1"></span>{{ room.area }}m<span>&#178;</span></h6>
                <h6 class="mr-4"><span class="mdi mdi-wifi mr-1"></span><span>Wifi</span></h6>
                <h6 class="mr-4"><span class="mdi mdi-snowflake mr-1"></span><span>Klimatyzacja</span></h6>
            </div>
            <router-link :to="{name: 'Room', params: {id: room.id}}" class="btn">Zobacz szczegóły</router-link>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Slider from "../main/Slider";
export default {
    components: {Slider},
    data() {
        return {
            rooms: [],
        }
    },
    methods: {
        getImages(items) {
            let images = []
                JSON.parse(items).forEach(item => {
                    images.push({src: require(`@/rooms/${item}`)})
                })
                return images
            }
    },
    mounted() {
        axios.get('/api/rooms')
            .then(resp => {
                this.rooms = resp.data.data
            })
            .catch(err => console.log(err))
    }
}
</script>

<style scoped>
.wrapper {
    background-color: #ececf6;
}
.room-section {
    background-color: #fff;
    width:60%;
    margin: auto;
    color: #9d836d;
    position: relative;
}
h6 {
    color: #9d836d;
}
.v-window.v-item-group.theme--dark.v-carousel {
    margin: auto;
    width: 700px;
    height: 427px;
}
.room-caption, .features {
    display: flex;
    margin: 0 auto;
    width:80%;
}
.room-caption {
    justify-content: space-between;
    border-bottom: 2px dashed #9d836d;
}
.btn {
    position:absolute;
    left:50%;
    transform: translateX(-50%);
    bottom:-2.5%;
    background-color: #9f7f64;
    color:white !important;
    transition: 0.3s;
}
.btn:hover {
    background-color: #7e532d;
}
</style>
