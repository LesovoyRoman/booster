<template>
    <div id="app">

        <appNav></appNav>

        <transition name="fade" mode="out-in">
            <keep-alive>

                <router-view></router-view>

            </keep-alive>
        </transition>

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