<template>
    <div class="my-4 wrapper">
        <div class="name-container">
            <h1>Nasza Restauracja</h1>
        </div>
        <p class="my-5">
            Przytulna i piękna Restauracja o znakomitym wystroju dla miłośników dań na jak najwyższym poziomie. Oferujemy dania na najwyższej jakości - dania kuchni międzynarodowej, a także specjały kuchni polskiej. Menu jest komponowane zależnie od pory roku. Z pewnościa twoje kubki smakowe znajdą u nas ukojenie, a ty z pewnością się nie rozczarujesz.
        </p>
        <div class="image-container row">
            <img class='col-4' src="https://cdn.pixabay.com/photo/2014/09/17/20/26/restaurant-449952_960_720.jpg" alt="">
            <img class='col-4' src="https://cdn.pixabay.com/photo/2016/03/27/21/34/restaurant-1284351_960_720.jpg" alt="">
            <img class='col-4' src="https://cdn.pixabay.com/photo/2017/03/02/02/16/place-setting-2110245_960_720.jpg" alt="">
        </div>
        <Menu />
        <div class="grill-section">
            <img src="https://i.gyazo.com/a1c6273aba5c33fc4311805b33723acf.jpg">
            <div class="darken"></div>
            <img src="https://i.gyazo.com/a1c6273aba5c33fc4311805b33723acf.jpg" class="small-image">
            <div class="caption">
                <h3 class="text-uppercase text-center">Garden Grill</h3>
                <p class="text-center">W sezonie letnim zapraszamy do hotelowego ogrodu, a czekać tam będą na Ciebie przysmaki z grilla.</p>
            </div>
        </div>
    </div>
</template>
<script>

import Menu from './Menu';
export default {
    components: {
        Menu,
    }
}
</script>

<style scoped>
    .wrapper {
        display:flex;
        flex-direction: column;
        justify-content: center;
        align-items:center;
    }
    h1 {
        color: #666;
    }
    .name-container {
        border-top: 3px solid #666;
        border-bottom: 3px solid #666;
    }
    p {
        width:70%;
        text-align: center;
    }
    .image-container img{
        width: 400px;
    }
    .grill-section {
        position: relative;
        margin:7% 0;
    }
    .grill-section img:first-child {
        width:100vw;
        height:100vh;
        background-attachment: fixed;
        background-position: center;
    }
    .darken {
        position: absolute;
        top:0;
        bottom: 0;
        left:0;
        right:0;
        background:
            /* top, transparent black, faked with gradient */
            linear-gradient(
                rgba(0, 0, 0, 0.7),
                rgba(0, 0, 0, 0.7)
            );
        z-index: 1;
    }
    .small-image {
        position:absolute;
        bottom: 15%;
        height:400px;
        left:4%;
        z-index:3;
        width:45%;
    }
    .caption {
        position: absolute;
        left: 60%;
        top:40%;
        width:40%;
        color: #e2e3e5;
        z-index:3;
        text-align: center;
    }
</style>
