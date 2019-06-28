<template>
        <a href="#" @click.prevent="toggle">
            <i class="fa fa-star" v-if="active"></i>
            <i class="fa fa-star-o" v-else></i>
        </a>
</template>

<script>
    export default {
        props: ['ison', 'resturantid'],

        data(){
            return {
                active: this.ison
            }
        },

        methods: {
            toggle(){
                axios.post(`/toggle-favorites/${this.resturantid}`).then(response => {
                    this.active = response.data
                })
            }
        }
    }
</script>
