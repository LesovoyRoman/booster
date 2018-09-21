<template>
  <div class="animated fadeIn" id="dashboard">

        <default-dashboard v-if="user_role === 'default'"></default-dashboard>

        <admin-dashboard v-if="user_role === 'admin'"></admin-dashboard>

        <performer-dashboard v-if="user_role === 'performer'"></performer-dashboard>

        <influencer-dashboard v-if="user_role === 'influencer'"></influencer-dashboard>

  </div>
</template>

<script>
  let vm = {};

  import DefaultDashboard from './dashboardsRoles/Default.vue'
  import AdminDashboard from './dashboardsRoles/Admin.vue'
  import InfluencerDashboard from './dashboardsRoles/Influencer.vue'
  import PerformerDashboard from './dashboardsRoles/Performer.vue'

  export default {
      name: 'Dashboard',
      data(){
          return {
              user_role: localStorage.getItem('user_role')
          }
      },
      components: {
          DefaultDashboard,
          AdminDashboard,
          InfluencerDashboard,
          PerformerDashboard
      },
      created(){

      }
  }

</script>