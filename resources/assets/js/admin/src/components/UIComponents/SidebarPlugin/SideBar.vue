<template>

  <div :class="sidebarClasses" :data-active-color="activeColor">
    <!--
            Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black | darkblue"
            Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
        -->
    <!-- -->
    <div class="logo">

      <svg width="31" id="logo_svg" height="40" viewBox="0 0 31 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g filter="url(#filter0_d)">
          <rect width="22.0573" height="32" fill="black" fill-opacity="0" transform="translate(4)"/>
          <path d="M12.8747 0C14.8905 0.710093 13.3787 5.84109 12.7144 7.03221C11.4316 9.36865 9.41589 11.0179 7.67502 12.9878C5.63637 15.3243 3.84968 17.9127 4.01003 21.005C4.30781 26.6858 10.9506 30.3508 15.6922 32C15.486 31.9313 15.5548 30.0759 15.5548 29.8697C15.5777 28.9535 15.6922 28.0372 15.8984 27.121C16.7459 23.3873 19.5863 20.753 21.0294 17.2713C22.335 14.1102 21.9914 9.9413 20.2734 6.78024C18.7845 4.0544 15.8755 1.05369 12.8747 0Z" fill="white"/>
          <path d="M16.6085 32C16.6085 32 16.6085 31.3816 16.6085 31.3586C16.5856 28.5183 17.3415 26.0444 18.7617 23.6163C20.7316 20.272 23.5491 16.9048 22.7932 12.7588C22.8619 13.1482 23.2513 13.8354 23.4345 14.2019C23.6865 14.66 23.9156 15.1181 24.1217 15.5763C24.5111 16.4238 24.9692 17.1568 25.3128 18.0272C26.2291 20.3408 26.5956 23.1811 24.6486 25.0823C23.2284 26.4567 21.4417 27.3042 19.9299 28.5641C18.6929 29.572 17.6164 30.7631 16.6085 32Z" fill="#ECD7CF"/>
        </g>
        <defs>
          <filter id="filter0_d" x="0" y="0" width="30.0574" height="40" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 255 0"/>
            <feOffset dy="4"/>
            <feGaussianBlur stdDeviation="2"/>
            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
          </filter>
        </defs>
      </svg>

      <h2 class="" id="admin_header_name">boostys</h2>

    </div>
    <div class="sidebar-wrapper" id="style-3" :data-background-color="backgroundColor" >

      <slot>
          <button id="add_action_sidebar" class="btn">Add company <i class="ti-plus"></i></button>
      </slot>
      <ul :class="navClasses">
        <!--By default vue-router adds an active class to each route link. This way the links are colored when clicked-->
        <router-link v-for="(link,index) in sidebarLinks" :to="link.path" tag="li" :ref="link.name" v-bind:key="link.path">
          <a>
            <i :class="link.icon"></i>

            <p>{{link.name}}
            </p>
          </a>
        </router-link>
      </ul>
      <!--<moving-arrow :move-y="arrowMovePx"></moving-arrow>-->
    </div>
  </div>
</template>
<script>
  import MovingArrow from './MovingArrow.vue'
  export default {
    props: {
      type: {
        type: String,
        default: 'sidebar',
        validator: (value) => {
          let acceptedValues = ['sidebar', 'navbar']
          return acceptedValues.indexOf(value) !== -1
        }
      },
      backgroundColor: {
        type: String,
        default: 'black',
        validator: (value) => {
          let acceptedValues = ['white', 'black', 'darkblue']
          return acceptedValues.indexOf(value) !== -1
        }
      },
      activeColor: {
        type: String,
        default: 'success',
        validator: (value) => {
          let acceptedValues = ['primary', 'info', 'success', 'warning', 'danger']
          return acceptedValues.indexOf(value) !== -1
        }
      },
      sidebarLinks: {
        type: Array,
        default: () => []
      }
    },
    components: {
      MovingArrow
    },
    computed: {
      sidebarClasses () {
        if (this.type === 'sidebar') {
          return 'sidebar'
        } else {
          return 'collapse navbar-collapse off-canvas-sidebar'
        }
      },
      navClasses () {
        if (this.type === 'sidebar') {
          return 'nav'
        } else {
          return 'nav navbar-nav'
        }
      },
      /**
       * Styles to animate the arrow near the current active sidebar link
       * @returns {{transform: string}}
       */
      arrowMovePx () {
        return this.linkHeight * this.activeLinkIndex
      }
    },
    data () {
      return {
        linkHeight: 60,
        activeLinkIndex: 0,

        windowWidth: 0,
        isWindows: false,
        hasAutoHeight: false
      }
    },
    methods: {
      findActiveLink () {
        this.sidebarLinks.find((element, index) => {
          let found = element.path === this.$route.path
          if (found) {
            this.activeLinkIndex = index
          }
          return found
        })
      }
    },
    mounted () {
      this.findActiveLink()
    },
    watch: {
      $route: function (newRoute, oldRoute) {
        this.findActiveLink()
      }
    }
  }

</script>
<style>

</style>
