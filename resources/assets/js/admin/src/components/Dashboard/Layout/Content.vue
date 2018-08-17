<template>
  <div class="content">
    <div class="container-fluid">
        <div class="breadcrumbs"><a href="/" class="link_breadcrumbs">< dashboard</a></div>
        <transition name="fade" mode="out-in">
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </transition>
    </div>
  </div>
</template>
<script>
  export default {}
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
