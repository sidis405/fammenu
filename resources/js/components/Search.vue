<template>
    <div>
        <input type="search" class="form-control" placeholder="Search..." v-model="query" @input="search">
        <div v-if="shouldShow">
            <div v-for="(res, key) in results">
                <span>{{ key }}</span>
                <ul>
                    <li v-for="item in res"><a :href="item.link">{{ item.name }}</a>
                        <favorite v-if="key === 'restaurants'"
                            :resturantid="item.id"
                            :ison="item.isFavorited" />
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                query: '',
                results: ''
            }
        },

        computed: {
            shouldShow(){
                if(this.results.length === 0) return false

                if(this.results['restaurants'].length || this.results['menus'].length) return true

                return false
            }
        },

        methods: {
            search(){
                if(this.query.length >= 3){
                    axios.get(`/search?query=${this.query}`).then(response => {
                        this.results = response.data
                    })
                }else{
                    console.log('impegnati di piu')
                }
            }
        }
    }
</script>
