require('./bootstrap');

window.Vue = require('vue');
let VueRouter = require('vue-router').default;

window.Vue.component('catalogue-component', require('./components/CatalogueComponent.vue').default);

const routes = [
    {
        path: '/categories/:id',
        name: 'categories',
        component: require('./components/ProductsComponent.vue').default
    },

];

let router = new VueRouter({
    routes
});

const app = new Vue({
    router
}).$mount('#app');
