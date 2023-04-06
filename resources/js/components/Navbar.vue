<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light row">
        <div class="collapse navbar-collapse col-10" id="navbar">
            <ul class="navbar-nav row">
                <li class="nav-item ml-5">
                    <router-link :to="{ name: 'Main' }" class="nav-link text-center">Hotel</router-link>
                </li>
                <li class="nav-item ml-5">
                    <router-link :to="{ name: 'Restaurant' }" class="nav-link text-center">Restauracja</router-link>
                </li>
                <li class="nav-item ml-5">
                    <router-link :to="{ name: 'Rooms' }" class="nav-link text-center">Pokoje</router-link>
                </li>
                <li class="nav-item ml-5">
                    <router-link :to="{ name: 'Opinions' }" class="nav-link text-center">Opinie</router-link>
                </li>
                <li class="nav-item ml-5 profile-button" id="admin-panel" v-if="user && user.admin_category_id">
                    <router-link :to="{name: 'Employee'}" class="nav-link text-center">Panel Paracownika</router-link>
                </li>
                <li class="nav-item ml-5 profile-button" id="user-panel" v-else-if="isLoggedIn">
                    <router-link :to="{name: 'Attractions'}" class="nav-link text-center">Atrakcje</router-link>
                </li>
                <li class="nav-item ml-5 profile-button" id="admin-panel" v-if="user && !user.admin_category_id">
                    <router-link :to="{name: 'Reservations'}" class="nav-link text-center">Moje rezerwacje</router-link>
                </li>
            </ul>
        </div>
        <div class="col-1 ml-5">
            <router-link id="btn-logout" :hidden="!isLoggedIn" :to="{ name: 'Logout' }" class="btn">Wyloguj się</router-link>
            <router-link id="btn-login" :hidden="isLoggedIn" :to="{ name: 'Login' }" class="btn">Logowanie</router-link>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
      return {
          isLoggedIn: false,
          user: false,
      }
    },
    mounted() {
        this.isLoggedIn = window.Laravel.isLoggedIn
        this.user = window.Laravel.user
    },
}
</script>

<style scoped>
    .navbar-nav {
        width: 80%;
    }
    .btn {
        background-color: #CDBAA8;
        color: #fff;
        transition: .3s;
    }
    .btn:hover {
        background-color: #b49f89;
    }
    .profile-button {
        font-weight: bold;
    }
    .row {
        justify-content: space-evenly;
    }
</style>
