<template>
  <nav class="navbar navbar-default" id="navbar_paper">
    <div class="container-fluid">
      <div class="navbar-header">

        <div class="logo">
          <img src="/static/img/boostr.png" alt="logo boostr" id="logo_svg">
          <h2 id="admin_header_name">boostys</h2>
        </div>

        <button type="button" class="navbar-toggle" :class="{toggled: $sidebar.showSidebar}" @click="toggleSidebar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar bar1"></span>
          <span class="icon-bar bar2"></span>
          <span class="icon-bar bar3"></span>
        </button>
      </div>
      <div class="navbar-right-menu">
        <ul class="nav navbar-nav navbar-right">
             <drop-down v-bind:title="'En'">
               <li><a href="#" @click="this.title='Ru'">Ru</a></li>
               <li><a href="#" @click="this.title='Ru'">En</a></li>
             </drop-down>
          <li class="open">
            <a href="#" class="dropdown-toggle btn-magnify" data-toggle="dropdown">
              <i class="ti-bell"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
  let title = '';
  export default {
    computed: {
      routeName () {
        const {name} = this.$route
        return this.capitalizeFirstLetter(name)
      }
    },
    data () {
      return {
        activeNotifications: false,
        title: title
      }
    },
    methods: {
      capitalizeFirstLetter (string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
      },
      toggleNotificationDropDown () {
        this.activeNotifications = !this.activeNotifications
      },
      closeDropDown () {
        this.activeNotifications = false
      },
      toggleSidebar () {
        this.$sidebar.displaySidebar(!this.$sidebar.showSidebar)
      },
      hideSidebar () {
        this.$sidebar.displaySidebar(false)
      }
    },

  }

</script>
<style>

</style>
