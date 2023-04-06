<template>
    <v-app>
        <Navbar />
        <router-view/>
        <Footer />
    </v-app>
</template>
<script>
import Navbar from "./Navbar";
import Main from "./main/Main";
import Restaurant from "./restaurant/Restaurant";
import Footer from "./Footer";
export default  {
   components: {
       Footer,
       Navbar, Main,Restaurant
   },
}
</script>
<style>
.v-application--wrap {
    display: block !important;
}
</style>
