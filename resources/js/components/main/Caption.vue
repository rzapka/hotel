<template>
    <div class="container">
        <div class="my-4 row">
            <div class="col-8 caption-bg-light rounded p-3">
                    <h3>Poznaj historię naszego hotelu</h3>
                    <button v-if="!read" class="float-right mr-5 btn mb-2" @click="read = true">Czytaj</button>
                    <button v-if="read" class="float-right mr-5 btn mb-2" @click="read = false">Schowaj</button>
                    <p v-if="read">
                         W miejscu gdzie obecnie znajduje się nasz hotel nigdyś funkcjonowała tutaj szkółka łowiecka utworzona przez Wiesława Radzikowskiego w 1926 r. Miłośnicy łowów spotykali się tutaj by umawiać się na wspólne polowania, szkolić nowych członków jak i po prostu miło spędzać czas. Jednak z czasem zainteresowanie zmalało i trzeba było sprzedać placówkę. W 1994 roku nasz własciciel Paweł Ulidowski postanowił ją odkupić i stworzyć nasz znakomity i luksusowy hotel.
                    </p>

            </div>
            <div class="col-3 caption-bg-dark ml-2 rounded">
                <h5 class="">Zarezerwuj wizytę już teraz</h5>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            read: false,
        }
    }
}
</script>

<style scoped>
    .caption-bg-light {
        background-color: #c5b09e;
        color: #fff;
        position: relative;
    }
    .btn {
        background-color: #9f7f64;
        color: #fff;
        transition: .3s;
    }
    .btn:hover {
        background-color: #7e532d;
    }
    .caption-bg-light div {
        background-color: #c0aa94;
    }
    .caption-bg-dark {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #9d836d;
        color: #fff;
    }
</style>
