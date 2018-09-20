<template>
  <div class="animated fadeIn" id="dashboard">
    <b-tabs pills>

      <b-tab title="Default" no-body>
        <default-dashboard></default-dashboard>
      </b-tab>

      <b-tab title="Admin">
        <admin-dashboard></admin-dashboard>
      </b-tab>

      <b-tab title="Performer" active>
        <performer-dashboard></performer-dashboard>
      </b-tab>

      <b-tab title="Influencer">
        <influencer-dashboard></influencer-dashboard>
      </b-tab>

    </b-tabs>

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

          }
      },
      components: {
          DefaultDashboard,
          AdminDashboard,
          InfluencerDashboard,
          PerformerDashboard
      }
  }

</script>