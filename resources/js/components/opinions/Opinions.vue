<template>
    <div>
        <button v-if="isLoggedIn && isOpinion" class="btn mx-auto" @click="redirectToEditForm()">Edytuj Opinie</button>
        <button v-else-if="isLoggedIn" class="btn mx-auto" @click="redirectToAddForm()">Dodaj opinie</button>
    <div class="wrapper">
    <v-card
        elevation="24"
        width="600"
        class="mx-auto"
    >
        <v-carousel
            :continuous="false"
            :cycle="cycle"
            :show-arrows="false"
            hide-delimiter-background
            delimiter-icon="mdi-minus"
            height="300"
        >
            <v-carousel-item
                v-for="(opinion,i) in opinions"
                :key="i"
            >
                <v-sheet
                    color="#dddddd"
                    height="100%"
                    tile
                >
                    <v-row
                        class="fill-height"
                        align="center"
                        justify="center"
                    >
                        <div class="px-3 text-h6 w-50 text-center">
                            "{{ opinion.message }}"
                            <p class="text-small">- {{ getUserName(opinion) }}</p>
                            <div class="stars">
                                <span v-for="n in opinion.stars" class="mdi mdi-star text-lg"></span>
                            </div>
                        </div>
                    </v-row>
                </v-sheet>
            </v-carousel-item>
        </v-carousel>
        <v-list two-line>
            <v-list-item>
                <v-list-item-action>
                    <v-switch
                        v-model="cycle"
                        label="Włącz automatyczne przełączanie"
                        inset
                    ></v-switch>
                </v-list-item-action>
            </v-list-item>
        </v-list>
    </v-card>
    </div>
    </div>
</template>
<script>
import axios from "axios";
import {ValidationObserver, ValidationProvider} from "vee-validate";

export default {
    data () {
        return {
            cycle: true,
            slides: [],
            opinions: [],
            isLoggedIn: false,
            isOpinion: false,
            opinionId: 0,
        }
    },
    components: {ValidationProvider, ValidationObserver},
    mounted() {

        axios.get('/api/opinions')
            .then(resp => this.opinions = resp.data.data)
            .catch(err => console.log(err))
        this.isLoggedIn = window.Laravel.isLoggedIn
        this.isUserOpinion()
    },
    methods: {
        redirectToAddForm() {
            this.$router.push({path: `/dodaj-opinie`})
        },
        redirectToEditForm() {
            this.$router.push({path: `/edytuj-opinie/${this.opinionId}`, params: {id: this.opinionId}})
        },
        isUserOpinion() {
            axios.post('/api/is-user-opinion')
                .then(resp => {
                    this.isOpinion = resp.data.isUserOpinion
                    this.opinionId = resp.data.opinionId
                })
                .catch(err => console.log(err))
        },
        getUserName(opinion) {
            return opinion.user.isCompany ? 'Firma ' + opinion.user.company : opinion.user.firstname + ' ' + opinion.user.lastname
        }
    }
}
</script>
<style scoped>
.wrapper {
    display:flex;
    justify-content:center;
    align-items:center;
    min-height: 60vh;
}
.text-small {
    font-size: 0.7em !important;
    color: #333;
    text-align:center;
    margin-top: 5%;
}
.stars {
    display:flex;
    justify-content: center;
    align-items: center;
    color: goldenrod;
    width:100%;
}
::v-deep .v-btn__content {
    color: crimson !important;
}
.btn {
    background-color: #9f7f64;
    color:white;
    display: block;
    margin-top:3%;
}
</style>
