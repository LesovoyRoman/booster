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
              <b-form-select v-model="selected" :options="options" class="mb-3" size="sm" id="select_lang" />
          <li class="open">
            <a href="#" class="dropdown-toggle btn-magnify" data-toggle="dropdown">
              <i class="ti-bell"></i>
            </a>
          </li>
          <drop-down ref="dropdown" title="Chet Faker" :notCaret="true" id="dropDownUser">
            <li>
                <a href="#" @click="logout()"><i class="ti ti-home"></i> Logout</a>
            </li>
          </drop-down>
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
        selected: 'En',
        options: [
            { value: 'Ru', text: 'Ru' },
            { value: 'En', text: 'En' },
        ],
        activeNotifications: false,
      }
    },
    methods: {
        logout: function() {

            return axios.post('/logout',
                {

                }).then(response => {
                window.location.href = '/';
            })
                .catch(error => {
                    console.log('logout error-> ', error.response);
                });
        },
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
      changeLang(lang, id) {
          this.$refs.dropdown.clickDropDown(lang, id);
      }
    },
  }

</script>
<style>

</style>
