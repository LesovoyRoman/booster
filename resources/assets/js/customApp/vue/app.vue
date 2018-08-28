<template>
    <div id="app">

        <appNav></appNav>

        <!--<transition name="fade" mode="out-in">
            <keep-alive>-->

            <div class="container">
                <router-view></router-view>
            </div>

            <!--</keep-alive>
        </transition>-->

    </div>
</template>

<script>

    import appNav from '../components/partials/nav.vue'

    export default {
        name: 'app',
        data() {
            return {

            }
        },
        methods: {

        },
        components: {
            appNav
        },
        created() {

        },

    }

</script>

<style>
    #app .title {
        font-size: 32px;
        display: block;
        text-align: center;
    }
    #form_login, #form_register, #navVue {
        max-width: 300px;
        display: block;
        margin: 15px auto;
    }
</style>