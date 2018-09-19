<template>
  <div class="animated fadeIn" id="dashboard">
    <b-tabs pills>

      <b-tab title="Default" no-body>
        <default-dashboard></default-dashboard>
      </b-tab>

      <b-tab title="Admin" active>
        <admin-dashboard></admin-dashboard>
      </b-tab>

      <b-tab title="Performer">

      </b-tab>

      <b-tab title="Influencer">

      </b-tab>

    </b-tabs>

  </div>
</template>

<script>
  let vm = {};

  import DefaultDashboard from './dashboardsRoles/Default.vue'
  import AdminDashboard from './dashboardsRoles/Admin.vue'

  export default {
      name: 'Dashboard',
      data(){
          return {

          }
      },
      components: {
          DefaultDashboard,
          AdminDashboard
      }
  }

</script>