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
             <drop-down ref="dropdown" title="En">
               <li><a href="#" @click="changeLang('Ru')">Ru</a></li>
               <li><a href="#" @click="changeLang('En')">En</a></li>
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
      },
      changeLang(lang) {
          this.$refs.dropdown.clickDropDown(lang);
      }
    },
  }

</script>
<style>

</style>
