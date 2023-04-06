<template>
    <div class="wrapper py-5">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <div class="container features mx-auto row mb-2">
                        <h6 class="mr-4"><span class="mdi mdi-border-radius mr-1"></span><span>{{ room.area }}m&#178;</span></h6>
                        <h6 class="mr-4"><span class="mdi mdi-wifi mr-1"></span><span>Wifi</span></h6>
                        <h6 class="mr-4"><span class="mdi mdi-snowflake mr-1"></span><span>Klimatyzacja</span></h6>
                    </div>
                    <p class="mt-4 room-description">{{ room.description }}</p>
                    <div class="in-room-price my-5">
                        <h3 class="my-3">W cenie pokoju:</h3>
                        <ul>
                            <li>- Śniadanie serwowane w Naszej Restauracji (6:30 - 10:30)</li>
                            <li>- Nielimitowane korzystanie z naszego SPA</li>
                            <li>- Nielimitowane korzystanie z naszych atrakcji</li>
                            <li>- Nielimitowane Wifi</li>
                            <li>- Parking</li>
                        </ul>
                    </div>
                    <Slider :items="getImages()" :hideDelimiters="true" />
                    <div class="mt-4">
                        <h3 class="text-center mb-5">Informacje o Rezerwacji</h3>
                        <div class="container features mx-auto row mb-2 d-flex justify-content-between">
                            <h6><span class="mdi mdi-timer mr-1"></span><span>Zameldowanie od: 14:00</span></h6>
                            <h6><span>Wymeldowanie do: 12:00</span><span class="ml-1 mdi mdi-timer"></span></h6>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="fixed-window">
                       <div class="text-center"><h1 class="d-inline">{{ room.price }}</h1><h4 class="d-inline">zł / NOC</h4></div>
                        <router-link :to="{name: 'BookRoom', params: {id: room.id}}" class="btn mt-3 d-block mx-auto">Zarezerwuj</router-link>
                        <div class="text-center">
                            <div class="caption pb-3 mt-5">
                                <h5 class="font-italic">
                                    NAJNIŻSZA CENA
                                </h5>
                                <h6>Gwarancja najniższej ceny tylko na naszej stronie www</h6>
                            </div>
                            <div class="caption pb-3 mt-5">
                                <h5 class="font-italic">
                                    BEZPIECZEŃSTWO
                                </h5>
                                <h6>Zapewniamy 100%
                                    bezpieczeństwo transakcji</h6>
                            </div>
                            <div class="caption pb-3 mt-5">
                                <h5 class="font-italic">
                                    POTWIERDZENIE
                                </h5>
                                <h6>Wysyłamy natychmiastowe
                                    potwierdzenie rezerwacji</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Slider from "../main/Slider";
export default {
    props: ['id'],
    components: {Slider},
    data() {
        return {
            room: {
                area: '',
                description: '',
                price: '',
                images: []
            }
        }
    },
    mounted() {
        axios.get(`/api/rooms/${this.id}`)
            .then(resp => this.room = resp.data.data)
            .catch(e => console.error(e.message))
    },
    methods: {
        getImages() {
            let images = []
            if (this.room.images.length) {
                JSON.parse(this.room.images).forEach(item => {
                    images.push({src: require(`@/rooms/${item}`)})
                })
                return images
            }
        }
    }
}
</script>

<style scoped>
.v-window.v-item-group.theme--dark.v-carousel {
    margin: auto;
    width: 700px;
    height: 427px;
}
.wrapper {
    background-color: #ececf6;
}
.col-9 {
    background: white;
    width:80%;
}
.features {
    padding-bottom: 0;
    width: 80%;
    color: #624e40;
    border-bottom: 2px dashed #9f7f64;;
}
.room-description, .in-room-price {
    width:80%;
    margin: 0 auto;
}
.room-description {
    font-size: 15px;
    color: #333;
}
h3, span {
    color: #9f7f64;
    font-weight: normal;
    letter-spacing: 1px;
}
ul {
    list-style: none;
    color: #624e40;
}
.col-3 {
    background-color: #B49F89;
    color:white;
    position: relative;
}
h1 {
    letter-spacing: 1px;
}
.fixed-window {
    position:sticky;
    top:10%;
}
.btn {
    background-color: #624e40;
    color:white;
}
.caption {
    border-bottom: 2px dashed white;
    width:80%;
    margin: 0 auto;
}
</style>
