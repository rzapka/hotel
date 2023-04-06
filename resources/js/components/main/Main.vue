<template>
        <div>
            <Slider :items="sliderImages"/>
             <Offers />
            <Caption />
            <Rooms />
        </div>
</template>

<script>
import Slider from "./Slider";
import Caption from "./Caption";
import Offers from "./Offers";
import Rooms from "./Rooms";
import Footer from "../Footer";
export default {
    components: {
        Slider,
        Caption,
        Offers,
        Rooms,
        Footer,
    },
    data () {
        return {
            sliderImages: [
                {
                    src: 'https://i.gyazo.com/185a80978a6c992fad7b3a1975833a39.jpg',
                },
                {
                    src: 'https://i.gyazo.com/69c636f4fb4996f2251f4242a908d30b.jpg',
                },
                {
                    src: 'https://i.gyazo.com/51a846b08bbf448ea45d1eb1fd42c5d2.jpg',
                },
                {
                    src: 'https://i.gyazo.com/0e46044c9c5d9bb2159446d31a1f9854.jpg',
                },
            ],
        }
    },
}
</script>

