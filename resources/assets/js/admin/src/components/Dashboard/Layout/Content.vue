<template>
  <div class="content">
    <div class="container-fluid">

        <Breadcrumbs></Breadcrumbs>

        <h2 id="header_admin_content">{{ nameHeader }}</h2>

        <transition name="fade" mode="out-in">
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </transition>
    </div>
  </div>
</template>
<script>
    import Breadcrumbs from '../../UIComponents/Breadcrumbs.vue'

    export default {
        components: {
            Breadcrumbs
        },
        methods: {
            setName() {
                this.nameHeader = this.$route.meta.nameHeader;
            }
        },
        created() {
            this.setName();
        },
        watch:{
            $route (to, from){
                this.setName();
            }
        }
    }
</script>
<style>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity .1s
  }

  .fade-enter,
  .fade-leave-to
  /* .fade-leave-active in <2.1.8 */

  {
    opacity: 0
  }
</style>
