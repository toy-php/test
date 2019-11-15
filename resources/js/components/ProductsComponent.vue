<template>
    <div class="columns is-multiline">
        <div class="column is-12-mobile is-6-tablet is-3-desktop" v-for="(product, index) in products" v-bind:key="index">
            <div class="card" >
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img :src="'/files/' + product.poster.path" :alt="product.name">
                    </figure>
                </div>
                <div class="card-content">
                    <p class="title">
                        {{ product.name }}
                    </p>
                    <div class="content">
                        {{ product.description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProductsComponent",
        data () {
            return {
                products: []
            };
        },
        mounted () {
            this.fetchProducts(this.$route.params.id);
        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            fetchData (route) {
                this.fetchProducts(route.params.id);
            },
            fetchProducts (category) {
                window.axios.default.get('products', {
                    params: {
                        category: category
                    }
                })
                    .then(response => {
                        this.products = response.data.data;
                        return response;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
