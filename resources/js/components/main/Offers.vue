<template>
    <div class="row mx-auto my-4">
        <div class="col-4">
           <div>
                <img src="https://cdn.pixabay.com/photo/2020/03/18/05/29/pool-4942724_960_720.jpg" alt="">
           </div>
           <div class="caption">
                <h4 class="text-center mt-2">Oferty I Vouchery</h4>
                <p>Jeżeli chcesz sprawić komuś prezent to zapraszamy do zakupu voucherów. Może to być pobyt w hotelu wraz z wszystkimi atrakcjami jak i wizyta w Spa wraz z zestawem masaży relaksacyjnych.
                </p>
           </div>
        </div>
        <div class="col-4">
           <div>
                <img src="https://cdn.pixabay.com/photo/2017/03/28/12/10/chairs-2181951_960_720.jpg" alt="">
           </div>
           <div class="caption">
                <h4 class="text-center mt-2">Konferencje</h4>
                <p>Chcesz zorganizować spotkanie o charakterze biznesowym? Żaden problem, posiadamy znakomitą salę konferencyjną dzięki która pozwoli Ci na to bez dwóch zdań. Do sali nie dochodzą żadne odgłosy z zewnątrz.
                </p>
           </div>
        </div>
        <div class="col-4">
           <div>
                <img src="https://cdn.pixabay.com/photo/2016/03/27/20/54/wedding-reception-1284245_960_720.jpg" alt="">
           </div>
           <div class="caption">
                <h4 class="text-center mt-2">Wesela</h4>
                <p>Chcesz mieć niezapomniane wesele? Świetnie się składa, bo posiadamy do tego ogromną salę wraz z wyszkolonym personelem. Nasza restauracja serwuje fenomenalne dania.
                </p>
           </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Offers"
}
</script>

<style scoped>
    .row {
        width:80%;
    }
    img {
        width:100%;
    }
    .caption {
        border: 1px solid #c5b09e;
        text-align: center;
        border-top: 10px solid #c5b09e;
        transition: 0.3s;
        padding: 0 10px;
        height:20vh;
    }
    .caption:hover {
        background-color: #c5b09e;
        color:white;
        border-top-color: white;
    }
    p {
        cursor: context-menu;
    }
</style>
