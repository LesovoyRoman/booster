const role = localStorage.getItem('user_role');


import Vue from 'vue'
import Router from 'vue-router'

// Containers
import Full from '@/containers/Full'

// Views
import Dashboard from '@/views/Dashboard'

/*import Colors from '@/views/theme/Colors'
import Typography from '@/views/theme/Typography'

import Charts from '@/views/Charts'
import Widgets from '@/views/Widgets'
import Loading from '@/views/Loading'*/

// Views - Components
/*import Cards from '@/views/base/Cards'
import Forms from '@/views/base/Forms'
import Switches from '@/views/base/Switches'
import Tables from '@/views/base/Tables'
import Breadcrumbs from '@/views/base/Breadcrumbs'
import Carousels from '@/views/base/Carousels'
import Collapses from '@/views/base/Collapses'
import Jumbotrons from '@/views/base/Jumbotrons'
import ListGroups from '@/views/base/ListGroups'
import Navs from '@/views/base/Navs'
import Navbars from '@/views/base/Navbars'
import Paginations from '@/views/base/Paginations'
import Popovers from '@/views/base/Popovers'
import ProgressBars from '@/views/base/ProgressBars'
import Tooltips from '@/views/base/Tooltips'*/

// Views - Buttons
/*import StandardButtons from '@/views/buttons/StandardButtons'
import ButtonGroups from '@/views/buttons/ButtonGroups'
import Dropdowns from '@/views/buttons/Dropdowns'
import SocialButtons from '@/views/buttons/SocialButtons'*/

// Views - Icons
/*import Flags from '@/views/icons/Flags'
import FontAwesome from '@/views/icons/FontAwesome'
import SimpleLineIcons from '@/views/icons/SimpleLineIcons'*/

// Views - Notifications
/*import Alerts from '@/views/notifications/Alerts'
import Badges from '@/views/notifications/Badges'
import Modals from '@/views/notifications/Modals'*/

// Views - Pages
import Page404 from '@/views/pages/Page404'
/*import Page500 from '@/views/pages/Page500'
import Login from '@/views/pages/Login'
import Register from '@/views/pages/Register'*/


// PERFORMERS ROUTES
// Campaigns
import MyCampaigns from '@/views/performers/campaigns/MyCampaigns'
import Campaign from '@/views/performers/campaigns/Campaign'
import NewCompany from '@/views/performers/campaigns/CreateNewCampaign'
import UpdateCampaign from '@/views/performers/campaigns/UpdateCampaign'

// Results
import ResultsCampaigns from '@/views/performers/campaigns/results/ResultsCampaigns'
import ResultCampign from '@/views/performers/campaigns/results/ResultCampaign'

// Feedbacks
import AllFeedbacks from '@/views/performers/campaigns/feedbacks/Feedbacks'
import Feedback from '@/views/performers/campaigns/feedbacks/Feedback'

// Bonuses
import InfluencerBonuses from '@/views/performers/campaigns/bonuses/InfluencerBonuses'
import CheckingBonuses from '@/views/performers/campaigns/bonuses/CheckingBonuses'

// Tariffs
import TariffPlan from '@/views/performers/rates/Tariff'

// Marketers
import AssistantsList from '@/views/performers/assistant/AssistantsList'
import CreateAssistant from '@/views/performers/assistant/AddAssistant'
import UpdateAssistant from '@/views/performers/assistant/UpdateAssistant'

// Influencers
import InfluencersList from '@/views/performers/influencers/Influencers'

// Gifts
import CreateGift from '@/views/performers/gifts/CreateGift'
import GiftsList from '@/views/performers/gifts/GiftsList'
import OrderedGifts from '@/views/performers/gifts/OrderedGifts'
import UpdateGift from '@/views/performers/gifts/UpdateGift'

// Account
import ProfileP from '@/views/performers/account/Profile'

// Invoices
import InvoicesList from '@/views/performers/invoices/InvoicesList'
import Invoice from '@/views/performers/invoices/Invoice'

///

// INFLUENCERS ROUTES
// Profile
 import ProfileI from '@/views/influencers/account/Profile'

// Offers
import Offers from '@/views/influencers/offers/Offers'

// Invites
import Invites from '@/views/influencers/invites/Invites'

// Points
import Points from '@/views/influencers/points/Points'

import MyCampaignsI from '@/views/influencers/campaigns/MyCampaigns'

// Catalog Gifts
import CatalogGifts from '@/views/influencers/catalog/Gifts'

// My Gifts
import MyGifts from '@/views/influencers/myGifts/MyGifts'

// Profile Campaign
import ProfileCampaign from '@/views/influencers/profileCampaign/ProfileCampaign'

import Influencer from '@/views/influencers/Influencer'


import InfluencersListAdmin from '@/views/admin/influencers/InfluencersAdmin'
import UsersListAdmin from '@/views/admin/users/Users'
import InvoicesListAdmin from '@/views/admin/invoices/Invoices'
import PerformersListAdmin from '@/views/admin/performers/Performers'
import AssistantsListAdmin from '@/views/admin/assistants/Assistants'


Vue.use(Router)

export default new Router({
  mode           : 'history',
  linkActiveClass: 'open active',
  scrollBehavior : () => ({ y: 0 }),
  routes         : [
    {
      path     : '/',
      redirect : '/dashboard',
      name     : 'Home',
      component: Full,
      children : [
        {
            path: 'dashboard',
            name: 'Dashboard',
            component: Dashboard,
        },
        {
            path: 'tariffs',
            name: 'Tariff Plan',
            component: TariffPlan,
            meta: { role_performer: true },
        },
        {
            path: 'assistants',
            name: 'Assistants',
            redirect: '/assistants/all-assistant',
            meta: {role_performer: true},
            component: {
                render (c) {
                    return c('router-view')
                },
            },
            children: [
                {
                    path: 'all-assistant',
                    name: 'AllAssistants',
                    component: AssistantsList,
                    meta: { role_performer: true },
                },
                {
                    path: 'new-assistant',
                    name: 'CreateAssistant',
                    component: CreateAssistant,
                    meta: { role_performer: true },
                },
                {
                    path: 'update-assistant-:idAssistant',
                    name: 'UpdateAssistant',
                    component: UpdateAssistant,
                    props: true,
                    meta: { role_performer: true },
                },
            ]
        },

        {
              path     : 'gifts',
              name     : 'Gifts',
              redirect: '/gifts/all-gifts',
              meta: { role_performer: true },
              component: {
                  render (c) {
                      return c('router-view')
                  },
              },
              children: [
                  {
                      path      : 'all-gifts',
                      name      : 'GiftsList',
                      component : GiftsList,
                      meta: { role_performer: true },
                  },
                  {
                      path      : 'create-gift',
                      name      : 'CreateGift',
                      component : CreateGift,
                      props: true,
                      meta: { role_performer: true },
                  },
                  {
                      path      : 'ordered-gifts',
                      name      : 'OrderedGifts',
                      component : OrderedGifts,
                      meta: { role_performer: true },
                  },
                  {
                      path      : 'update-gift-:idGift',
                      name      : 'UpdateGift',
                      component : UpdateGift,
                      props     : true,
                      meta: { role_performer: true }
                  }
              ],
        },
        {
            path: 'invoices',
            name: 'Invoices',
            redirect: '/invoices/all',
            meta: { role_performer: true },
            component: {
                render (c) {
                    return c('router-view')
                },
            },
            children: [
                {
                    path: '/invoices/all',
                    name: 'InvoicesList',
                    component: InvoicesList,
                    meta: { role_performer: true },
                },
                {
                    path: 'invoices/invoice-id-:id',
                    name: 'Invoice',
                    component: Invoice,
                    props: true,
                    meta: { role_performer: true },
                }
            ]
        },
        {
            path: 'influencers',
            name: 'Influencers',
            component: InfluencersList,
            meta: { role_performer: true },
        },
        {
            path: 'account',
            name: 'Account',
            redirect: '/account/profile',
            component: {
                render (c) {
                    return c('router-view')
                },
            },
            children: [
                {
                    path      : '/account/profile',
                    name      : 'ProfileI',
                    component : ProfileI, // influencer
                    props: true,
                    meta: { role_influencer: true },
                },
                {
                    path      : '/account/profile',
                    name      : 'ProfileP',
                    component : ProfileP, // performer
                    props: true,
                    meta: { role_performer: true },
                },
            ]
        },
        {
            path: 'campaigns',
            redirect: '/campaigns/my-campaigns',
            name: 'Campaigns',
            meta: { role_performer: true },
            component: {
                render (c) {
                    return c('router-view')
                },
            },
            children: [
                {
                    path     : 'checking-bonuses',
                    name     : 'CheckingBonuses',
                    component: CheckingBonuses,
                    meta: { role_performer: true },
                },
                {
                    path     : 'feedbacks',
                    name     : 'Feedbacks',
                    redirect: '/campaigns/feedbacks/all-feedbacks',
                    component: {
                        render (c) {
                            return c('router-view')
                        },
                    },
                    children: [
                        {
                            path     : 'feedback-:id',
                            name     : 'Feedback',
                            component: Feedback,
                            meta: { role_performer: true },
                            props: true,
                        },
                        {
                            path     : 'all-feedbacks',
                            name     : 'AllFeedbacks',
                            component: AllFeedbacks,
                            meta: { role_performer: true },
                        },
                    ]
                },
                {
                    path     : 'influencer-:id-bonuses',
                    name     : 'InfluencerBonuses',
                    component: InfluencerBonuses,
                    meta: { role_performer: true },
                    props: true,
                },
                {
                    path     : 'my-campaigns',
                    name     : 'MyCampaigns',
                    component: MyCampaigns,
                    meta: { role_performer: true },
                },
                {
                    path       : 'add-new',
                    name       : 'AddNewCampaign',
                    component  : NewCompany,
                    meta: { role_performer: true },
                },
                {
                    path       : 'update-campaign-:idCampaign',
                    name       : 'UpdateCampaign',
                    component  : UpdateCampaign,
                    props      : true,
                    meta: { role_performer: true }
                },
                {
                    path     : 'campaign-id-:id',
                    name     : 'Campaign',
                    component: Campaign,
                    meta: { role_performer: true },
                    props: true,
                },
                {
                    path     : 'results',
                    name     : 'Results',
                    redirect: '/campaigns/results/results-campaigns',
                    meta: { role_performer: true },
                    component: {
                        render (c) {
                            return c('router-view')
                        },
                    },
                    children: [
                        {
                            path     : 'results-campaigns',
                            name     : 'ResultsCampaigns',
                            component: ResultsCampaigns,
                            props: true,
                            meta: { role_performer: true },
                        },
                        {
                            path     : 'result',
                            name     : 'ResultCampaign',
                            component: ResultCampign,
                            props: true,
                            meta: { role_performer: true },
                        },
                    ]
                },
            ],
        },

          // INFLUENCERS
        {
            path: 'offers',
            name: 'Offers',
            component: Offers,
            meta: { role_influencer: true },
        },
        {
          path: 'invites',
          name: 'Invites',
          component: Invites,
            meta: { role_influencer: true },
        },
        {
          path: 'points',
          name: 'Points',
          component: Points,
            meta: { role_influencer: true },
        },
        {
          /* @todo change path */
          path: 'influencer-campaigns',
          name: 'CampaignsInfluencer',
          component: MyCampaignsI,
            meta: { role_influencer: true },
        },
        {
          path: 'catalog-gifts',
          name: 'CatalogGifts',
          component: CatalogGifts,
            meta: { role_influencer: true },
        },
        {
          path: 'my-gifts',
          name: 'MyGifts',
          component: MyGifts,
            meta: { role_influencer: true },
        },
        {
          path     : 'profile-campaign-id-:id',
          name     : 'ProfileCampaign',
          component: ProfileCampaign,
          props: true,
            meta: { role_influencer: true },
        },
        {
          path     : 'influencer-:idInfluencer',
          name     : 'Influencer',
          component: Influencer,
          props: true,
            meta: { role_performer: true },
        },

          /// admin
        {
            path     : '/admin/',
            name     : 'Admin',
            redirect : 'admin/users',
            meta: { role_admin: true },
            component: {
                render (c) { return c('router-view') },
            },
            children: [
                {
                    path      : '/admin/influencers',
                    name      : 'InfluencersAdmin',
                    component : InfluencersListAdmin,
                    meta: { role_admin: true },
                },
                {
                    path      : '/admin/users',
                    name      : 'UsersAdmin',
                    component : UsersListAdmin,
                    meta: { role_admin: true },
                },
                {
                    path      : '/admin/invoices',
                    name      : 'InvoicesAdmin',
                    component : InvoicesListAdmin,
                    meta: { role_admin: true },
                },
                {
                    path      : '/admin/performers',
                    name      : 'PerformersAdmin',
                    component : PerformersListAdmin,
                    meta: { role_admin: true },
                },
                {
                    path      : '/admin/assistants',
                    name      : 'AssistantsAdmin',
                    component : AssistantsListAdmin,
                    meta: { role_admin: true },
                }
            ]
        },


          /// default
        /*{
          path     : 'theme',
          redirect : '/theme/colors',
          name     : 'Theme',
          component: {
            render (c) { return c('router-view') },
          },
          children: [
            {
              path     : 'colors',
              name     : 'Colors',
              component: Colors,
            },
            {
              path     : 'typography',
              name     : 'Typography',
              component: Typography,
            },
          ],
        },
        {
          path     : 'charts',
          name     : 'Charts',
          component: Charts,
        },
        {
          path     : 'widgets',
          name     : 'Widgets',
          component: Widgets,
        },
        {
          path     : 'loading',
          name     : 'Loading',
          component: Loading,
        },
        {
          path     : 'base',
          redirect : '/base/cards',
          name     : 'Base',
          component: {
            render (c) { return c('router-view') },
          },
          children: [
            {
              path     : 'cards',
              name     : 'Cards',
              component: Cards,
            },
            {
              path     : 'forms',
              name     : 'Forms',
              component: Forms,
            },
            {
              path     : 'switches',
              name     : 'Switches',
              component: Switches,
            },
            {
              path     : 'tables',
              name     : 'Tables',
              component: Tables,
            },
            {
              path     : 'breadcrumbs',
              name     : 'Breadcrumbs',
              component: Breadcrumbs,
            },
            {
              path     : 'carousels',
              name     : 'Carousels',
              component: Carousels,
            },
            {
              path     : 'collapses',
              name     : 'Collapses',
              component: Collapses,
            },
            {
              path     : 'jumbotrons',
              name     : 'Jumbotrons',
              component: Jumbotrons,
            },
            {
              path     : 'list-groups',
              name     : 'List Groups',
              component: ListGroups,
            },
            {
              path     : 'navs',
              name     : 'Navs',
              component: Navs,
            },
            {
              path     : 'navbars',
              name     : 'Navbars',
              component: Navbars,
            },
            {
              path     : 'paginations',
              name     : 'Paginations',
              component: Paginations,
            },
            {
              path     : 'popovers',
              name     : 'Popovers',
              component: Popovers,
            },
            {
              path     : 'progress-bars',
              name     : 'Progress Bars',
              component: ProgressBars,
            },
            {
              path     : 'tooltips',
              name     : 'Tooltips',
              component: Tooltips,
            },
          ],
        },
        {
          path     : 'buttons',
          redirect : '/buttons/buttons',
          name     : 'Buttons',
          component: {
            render (c) { return c('router-view') },
          },
          children: [
            {
              path     : 'standard-buttons',
              name     : 'Standard Buttons',
              component: StandardButtons,
            },
            {
              path     : 'button-groups',
              name     : 'Button Groups',
              component: ButtonGroups,
            },
            {
              path     : 'dropdowns',
              name     : 'Dropdowns',
              component: Dropdowns,
            },
            {
              path     : 'social-buttons',
              name     : 'Social Buttons',
              component: SocialButtons,
            },
          ],
        },
        {
          path     : 'icons',
          redirect : '/icons/font-awesome',
          name     : 'Icons',
          component: {
            render (c) { return c('router-view') },
          },
          children: [
            {
              path     : 'flags',
              name     : 'Flags',
              component: Flags,
            },
            {
              path     : 'font-awesome',
              name     : 'Font Awesome',
              component: FontAwesome,
            },
            {
              path     : 'simple-line-icons',
              name     : 'Simple Line Icons',
              component: SimpleLineIcons,
            },
          ],
        },
        {
          path     : 'notifications',
          redirect : '/notifications/alerts',
          name     : 'Notifications',
          component: {
            render (c) { return c('router-view') },
          },
          children: [
            {
              path     : 'alerts',
              name     : 'Alerts',
              component: Alerts,
            },
            {
              path     : 'badges',
              name     : 'Badges',
              component: Badges,
            },
            {
              path     : 'modals',
              name     : 'Modals',
              component: Modals,
            },
          ],
        },
      ],
    },
    {
      path     : '/pages',
      redirect : '/pages/404',
      name     : 'Pages',
      component: {
        render (c) { return c('router-view') },
      },
      children: [
        {
          path     : '404',
          name     : 'Page404',
          component: Page404,
        },
        {
          path     : '500',
          name     : 'Page500',
          component: Page500,
        },
        {
          path     : 'login',
          name     : 'Login',
          component: Login,
        },
        {
          path     : 'register',
          name     : 'Register',
          component: Register,
        },*/
      ],
    },
    {
      path     : '*',
      name     : '404',
      component: Page404,
    },
  ],
})


