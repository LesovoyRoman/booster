<template>
    <div id="app">
        <div class="container">

            <transition name="fade" mode="out-in">
                <appNav></appNav>
            </transition>

            <transition name="fade" mode="out-in">
                <Caside></Caside>
            </transition>

            <!--<transition name="fade" mode="out-in">
                <keep-alive>-->

                    <router-view></router-view>

                <!--</keep-alive>
            </transition>-->

            <div class="clearfix"></div>
            <cfooter></cfooter>

        </div>
    </div>
</template>

<script>

    let vm = {};


    import appNav from '../components/partials/nav.vue'
    import Caside from '../components/partials/aside.vue'
    import cfooter from '../components/partials/footer.vue'

    export default {
        name: 'app',
        data() {
            return {

            }
        },
        methods: {

        },
        components: {
            appNav,
            Caside,
            cfooter
        },
        created() {

        },

    }

</script>

<style>

</style>