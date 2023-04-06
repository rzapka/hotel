<template>
    <div class="my-5">
        <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
            <li v-for="item in menu" :key="item.id" class="nav-item" role="presentation">
               <button @click="scroll(item.name)" class="nav-link text-uppercase" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                   {{ item.name }}
               </button>
            </li>
        </ul>
         <section v-for='item in menu' class="mx-auto" :key="item.id" :id="item.name">
             <h3 class="text-uppercase text-secondary font-italic text-center my-5">
                 {{ item.name }}
             </h3>
             <ul class="meals">
               <li v-for="meal in item.meals" :key="meal.id">
                    <div class="list-container">
                        <p>{{ meal.name }}</p>
                        <p>{{ meal.price }} zł</p>
                    </div>
                </li>
             </ul>
         </section>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            menu: []
        }
    },
    mounted() {
        this.loadMenu()
    },
    methods: {
        loadMenu() {
            axios.get('/api/meal-categories')
                .then(resp => {
                    this.menu = resp.data.data
                })
                .catch(err => console.log(err))
        },
        scroll(name) {
            document.getElementById(name).scrollIntoView({ behavior: 'smooth', block: 'center' })
        }
    }
}
</script>

<style scoped>

    ul.nav {
        border-bottom: 3px solid #666;
        border-top: 3px solid #666;
    }
    button.nav-link {
        color: #666;
        font-size: 18px;
        font-weight: bolder;
    }
    .meals {
        list-style:none;
    }
    .list-container {
        display: flex;
        width:70%;
        margin: 0 auto;
        flex-direction:row;
        justify-content: space-between;
    }
    #pills-home-tab.active {
        background-color: #c5b09e;
        border-radius: 0;
        color: #fff;
    }
</style>
