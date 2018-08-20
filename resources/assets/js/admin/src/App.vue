<template>
  <div :class="{'nav-open': $sidebar.showSidebar}">
    <transition name="fade" mode="out-in">
      <keep-alive>
        <router-view></router-view>
      </keep-alive>
    </transition>
    <!--This sidebar appears only for screens smaller than 992px-->
    <side-bar type="navbar" :sidebar-links="$sidebar.sidebarLinks"></side-bar>
  </div>
</template>

<script>
  export default {}
</script>

<style lang="scss"></style>
