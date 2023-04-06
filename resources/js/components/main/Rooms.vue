<template>
    <div class="wrapper pt-5 mb-5">
       <div class="main-element">
           <div>
                <h4>Pokoje i Apartamenty</h4>
                <p>Nasz hotel miejsce dla osób planujących urlop jak i dla osób podróżujących służbowo. Znakomite usytuowanie hotelu powoduje, że można odpocząć w ciszy i spokoju, a nasze atrakcje z pewnością sprawią, że nie będziesz się nudził.</p>
               <router-link :to="{ name: 'Rooms' }" class="btn">Zobacz Pokoje</router-link>
           </div>
           <div class="element left-element">
               <div class="bg-white">
                  <h1>36</h1>
                   <div class="aperture">
                       <div class="line line-left">
                           <h5 class="line-caption line-caption-left">Wygodnych Pokoi</h5>
                       </div>
                   </div>
               </div>
           </div>
           <div class="element right-element">
               <div class="bg-white">
                   <h1>24</h1>
                   <div class="aperture">
                       <div class="line line-right">
                           <h5 class="line-caption line-caption-right">Pokoi z Tarasem</h5>
                       </div>
                   </div>
               </div>
           </div>
           <div class="element bottom-element">
               <div class="bg-white">
                   <h1>120</h1>
                   <div class="aperture">
                       <div class="line line-bottom">
                           <h5 class="line-caption line-caption-bottom">Maksymalna Liczba Gości</h5>
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </div>
</template>

<script>
export default {
    name: "Rooms",
}
</script>

<style scoped>
    .wrapper {
        background-color: #EAECEC;
        height: 70vh;
    }
    .main-element {
        position: relative;
        border-radius: 50%;
        border: 3px dashed white;
        padding: 50px;
        margin: 0 auto;
        width: 33%;
        text-align: center;
        color: #9f7f64;
    }
    .btn {
        background-color: #9f7f64;
        color:white;
        transition: 0.3s;
    }
    .btn:hover {
        background-color: #7e532d;
    }
    .element {
        position: absolute;
        left: -25%;
        top:-5%;
        border: 3px dashed white;
        border-radius: 50%;
        padding: 20px;
    }
    .left-element {
        left: -25%;
        top:-5%;
    }
    .right-element {
        left: 90%;
        top:-10%;
    }
    .bottom-element {
        left: 45%;
        top:90%;
    }
    .bg-white {
        padding:40px;
        border-radius: 50%;
    }
    .aperture {
        position:relative;
        width:3vh;
        height:3vh;
        border-radius: 50%;
        background-color: #EAECEC;
        margin: 0 auto;
    }
    .line {
        position:absolute;
        top:50%;
        transform: translateY(-50%);
        background-color: #9f7f64;
        height:2px;
        width: 300px;
    }
    .line-bottom {
        right:50%;
        width:400px;
    }
    .line-left {
        right:50%;
    }
    .line-right {
        left: 50%;
    }
    .line-caption {
        position: absolute;
        bottom:0;
        right:20%;
        width:100%;
    }
    .line-caption-right {
        right:0;
        left:25%;
    }
</style>
