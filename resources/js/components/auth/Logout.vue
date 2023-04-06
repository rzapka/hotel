<script>
import axios from "axios";

export default {
    mounted() {
        if (!window.Laravel.isLoggedIn) {
            this.$router.push('/')
        }
        axios.get('/sanctum/csrf-cookie').then(resp => {
            axios.post('api/logout').then(resp => {
                if (resp.data.success) {
                    location.reload()
                }
            }).catch(err => console.error(err))
        })
    }
}
</script>
