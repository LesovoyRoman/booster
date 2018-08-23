import DashboardLayout from '../components/Dashboard/Layout/DashboardLayout.vue'
// GeneralViews
import NotFound from '../components/GeneralViews/NotFoundPage.vue'

// Admin pages
import Overview from '../components/Dashboard/Views/Overview.vue'
import UserProfile from '../components/Dashboard/Views/UserProfile.vue'
import Notifications from '../components/Dashboard/Views/Notifications.vue'
import Icons from '../components/Dashboard/Views/Icons.vue'
import Typography from '../components/Dashboard/Views/Typography.vue'
import Campaigns from '../components/Dashboard/Views/Campaign/Campaigns.vue'
import CampaignCreate from '../components/Dashboard/Views/Campaign/CampaignCreate.vue'
import ResultsCampaigns from '../components/Dashboard/Views/Campaign/ResultCampaigns.vue'
import ChecksBonuses from '../components/Dashboard/Views/Campaign/ChecksBonuses.vue'
import BonusesCampaigns from '../components/Dashboard/Views/Campaign/BonusesCampaings.vue'

const routes = [
  {
    path: '/',
    component: DashboardLayout,
    redirect: '/admin/overview',
  },
  {
    path: '/admin',
    component: DashboardLayout,
    redirect: '/admin/overview',
    children: [
      {
        path: 'overview',
        name: 'overview',
        component: Overview,
        meta: {nameHeader: 'Dashboard'}
      },
      {
        path: 'campaigns',
        name: 'campaigns',
        component: Campaigns,
        meta: {nameHeader: 'My Campaigns'}
      },
      {
          path: 'campaigns/results',
          name: 'resultsCampaigns',
          meta: {nameHeader: 'Results Campaigns'},
          component: ResultsCampaigns,

      },
      {
          path: 'campaigns/bonuses',
          name: 'bonusesCampaigns',
          meta: {nameHeader: 'Bloggers Bonuses'},
          component: BonusesCampaigns,
      },
      {
          path: 'campaigns/check-bonuses',
          name: 'checkBonusesCampaigns',
          meta: {nameHeader: 'Checks Bonuses'},
          component: ChecksBonuses,
      },
      {
          path: 'campaigns/create',
          name: 'campaignCreate',
          component: CampaignCreate,
          meta: {nameHeader: 'Create New Campaign'}
      },
      {
        path: 'stats',
        name: 'stats',
        component: UserProfile,
        meta: {nameHeader: 'User Profile'}
      },
      {
        path: 'notifications',
        name: 'notifications',
        component: Notifications,
        meta: {nameHeader: 'Notifications'}
      },
      {
        path: 'icons',
        name: 'icons',
        component: Icons,
        meta: {nameHeader: 'Icons'}
      },
      {
        path: 'typography',
        name: 'typography',
        component: Typography,
        meta: {nameHeader: 'Typography'}
      },
    ]
  },
  {
    path: '*',
    component: NotFound,
    meta: {nameHeader: 'Page Not Found'}
  }
]

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes
