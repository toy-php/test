<template>
    <div class="columns">
        <div class="column">
            <categories-component></categories-component>
        </div>
        <div class="column is-four-fifths">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>

    import CategoriesComponent from "./CategoriesComponent";

    export default {
        name: "CatalogueComponent",
        components: {
            CategoriesComponent
        }
    }
</script>

<style scoped>

</style>
