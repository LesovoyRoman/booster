<template>
  <div class="sidebar">
    <SidebarHeader/>
    <SidebarForm/>
    <nav class="sidebar-nav">
      <div slot="header"/>
      <ul class="nav">
        <template v-for="(item, index) in items_role">
          <template v-if="item.title">
            <SidebarNavTitle
              :key="index"
              :name="item.name"
              :classes="item.class"
              :wrapper="item.wrapper" />
          </template>
          <template v-else-if="item.divider">
            <SidebarNavDivider
              :key="index"
              :classes="item.class" />
          </template>
          <template v-else-if="item.label">
            <SidebarNavLabel
              :key="index"
              :name="item.name"
              :url="item.url"
              :icon="item.icon"
              :label="item.label"
              :classes="item.class"
            />
          </template>
          <template v-else>
            <template v-if="item.children">
              <!-- First level dropdown -->
              <SidebarNavDropdown
                :key="index"
                :name="item.name"
                :url="item.url"
                :icon="item.icon">
                <template v-for="(childL1, index1) in item.children">
                  <template v-if="childL1.children">
                    <!-- Second level dropdown -->
                    <SidebarNavDropdown
                      :key="index1"
                      :name="childL1.name"
                      :url="childL1.url"
                      :icon="childL1.icon">
                      <li
                        class="nav-item"
                        :key="index2"
                        v-for="(childL2, index2) in childL1.children">
                        <SidebarNavLink
                          :name="childL2.name"
                          :url="childL2.url"
                          :icon="childL2.icon"
                          :badge="childL2.badge"
                          :variant="item.variant"
                        />
                      </li>
                    </SidebarNavDropdown>
                  </template>
                  <template v-else>
                    <SidebarNavItem
                      :key="index1"
                      :classes="item.class">
                      <SidebarNavLink
                        :name="childL1.name"
                        :url="childL1.url"
                        :icon="childL1.icon"
                        :badge="childL1.badge"
                        :variant="item.variant"
                      />
                    </SidebarNavItem>
                  </template>
                </template>
              </SidebarNavDropdown>
            </template>
            <template v-else>
              <SidebarNavItem
                :key="index"
                :classes="item.class">
                <SidebarNavLink
                  :name="item.name"
                  :url="item.url"
                  :icon="item.icon"
                  :badge="item.badge"
                  :variant="item.variant" />
              </SidebarNavItem>
            </template>
          </template>
        </template>

      </ul>
      <slot/>
    </nav>
    <SidebarFooter/>
    <SidebarMinimizer/>


  </div>
</template>
<script>
import SidebarFooter from './SidebarFooter'
import SidebarForm from './SidebarForm'
import SidebarHeader from './SidebarHeader'
import SidebarMinimizer from './SidebarMinimizer'
import SidebarNavDivider from './SidebarNavDivider'
import SidebarNavDropdown from './SidebarNavDropdown'
import SidebarNavLink from './SidebarNavLink'
import SidebarNavTitle from './SidebarNavTitle'
import SidebarNavItem from './SidebarNavItem'
import SidebarNavLabel from './SidebarNavLabel'

let vm = {};

export default {
  name : 'Sidebar',
  props: {
    navItems: {
      type    : Array,
      required: true,
      default : () => [],
    },
  },
  data(){
    return {
        user_role: localStorage.getItem('user_role'),
        items_role: [],
    }
  },
  components: {
    SidebarFooter,
    SidebarForm,
    SidebarHeader,
    SidebarMinimizer,
    SidebarNavDivider,
    SidebarNavDropdown,
    SidebarNavLink,
    SidebarNavTitle,
    SidebarNavItem,
    SidebarNavLabel,
  },
  created(){
      vm = this;
      const role_admin = 'role_admin';
      const role_performer = 'role_performer';
      const role_influencer = 'role_influencer';

      //console.log('role sidebar -> ' + vm.user_role)

      vm.navItems.forEach(function (item, index) {

          if ("meta" in item) {
              if(item.meta.dashboard === true) {
                  console.log(item.meta)
                  vm.items_role.push(Object.assign({}, vm.navItems[index])) // dashboards
              }

              if(item.meta.role_admin === true && vm.user_role === 'admin'){
                  //console.log('admin ' + item.name)
                  vm.items_role.push(Object.assign({}, vm.navItems[index])) // only nav for admin
              }
              if (item.meta.role_performer === true && vm.user_role === 'performer'){
                  //console.log('performer ' + item.name)
                  vm.items_role.push(Object.assign({}, vm.navItems[index])) // only nav for admin
              }
              if (item.meta.role_influencer === true && vm.user_role === 'influencer'){
                  //console.log('influencer ' + item.name)
                  vm.items_role.push(Object.assign({}, vm.navItems[index])) // only nav for admin
              }

          }
      })
      //console.log(vm.items_role)
  },
  methods: {
    handleClick (e) {
      e.preventDefault()
      e.target.parentElement.classList.toggle('open')
    },
  },
}

</script>

<style lang="css">
  .nav-link {
    cursor: pointer;
  }

</style>
