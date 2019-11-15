<template>
    <aside class="menu">
        <p class="menu-label">
            Категории
        </p>
        <ul class="menu-list">
            <li v-for="(category, index) in categories" v-bind:key="index">
                <router-link :to="{ name: 'categories', params: { id: category.id }}">{{ category.name }}</router-link>
            </li>
        </ul>
    </aside>
</template>

<script>
    export default {
        name: "CategoriesComponent",
        data() {
            return {
                categories: []
            }
        },
        mounted() {
            this.fetchCategories();
        },
        methods: {
            fetchCategories() {
                window.axios.default.get('categories')
                    .then(response => {
                        this.categories = response.data.data;
                        return response;
                    })
                    .then(response => {
                        if (this.$route.name !== 'categories') {
                            let category = response.data.data[0];
                            this.$router.push({
                                name: 'categories',
                                params:
                                    {
                                        id: category.id
                                    }
                            });
                        }
                        return response;
                    })
            },
        }
    }
</script>

<style scoped>

</style>
