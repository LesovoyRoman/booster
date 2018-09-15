import Vue from 'vue'
import Router from 'vue-router'

// Containers
import Full from '@/containers/Full'

// Views
import Dashboard from '@/views/Dashboard'

import Colors from '@/views/theme/Colors'
import Typography from '@/views/theme/Typography'

import Charts from '@/views/Charts'
import Widgets from '@/views/Widgets'
import Loading from '@/views/Loading'

// Views - Components
import Cards from '@/views/base/Cards'
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
import Tooltips from '@/views/base/Tooltips'

// Views - Buttons
import StandardButtons from '@/views/buttons/StandardButtons'
import ButtonGroups from '@/views/buttons/ButtonGroups'
import Dropdowns from '@/views/buttons/Dropdowns'
import SocialButtons from '@/views/buttons/SocialButtons'

// Views - Icons
import Flags from '@/views/icons/Flags'
import FontAwesome from '@/views/icons/FontAwesome'
import SimpleLineIcons from '@/views/icons/SimpleLineIcons'

// Views - Notifications
import Alerts from '@/views/notifications/Alerts'
import Badges from '@/views/notifications/Badges'
import Modals from '@/views/notifications/Modals'

// Views - Pages
import Page404 from '@/views/pages/Page404'
import Page500 from '@/views/pages/Page500'
import Login from '@/views/pages/Login'
import Register from '@/views/pages/Register'


// PERFORMERS ROUTES
// Campaigns
import MyCampaigns from '@/views/performers/campaigns/MyCampaigns'
import Campaign from '@/views/performers/campaigns/Campaign'

// Results
import ResultsCampaigns from '@/views/performers/campaigns/results/ResultsCampaigns'
import ResultCampign from '@/views/performers/campaigns/results/ResultCampaign'

// Feedbacks
import AllFeedbacks from '@/views/performers/campaigns/feedbacks/Feedbacks'
import Feedback from '@/views/performers/campaigns/feedbacks/Feedback'

// Bonuses
import InfluencerBonuses from '@/views/performers/campaigns/bonuses/InfluencerBonuses'
import CheckingBonuses from '@/views/performers/campaigns/bonuses/CheckingBonuses'

import NewCompany from '@/views/performers/campaigns/CreateNewCampaign'

// Tariffs
import TariffPlan from '@/views/performers/rates/Tariff'

// Marketers
import AssistantsList from '@/views/performers/assistant/AssistantsList'
import CreateAssistant from '@/views/performers/assistant/AddAssistant'

// Influencers
import InfluencersList from '@/views/performers/influencers/Influencers'

// Gifts
import CreateGift from '@/views/performers/gifts/CreateGift'
import GiftsList from '@/views/performers/gifts/GiftsList'
import OrderedGifts from '@/views/performers/gifts/OrderedGifts'

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

/// admin
import InfluencersListAdmin from '@/views/admin/influencers/InfluencersAdmin'
import UsersListAdmin from '@/views/admin/users/Users'

Vue.use(Router)

export default new Router({
  mode           : 'history', // Demo is living in GitHub.io, so required!
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
          path     : 'dashboard',
          name     : 'Dashboard',
          component: Dashboard,
        },
        {
            path: 'tariffs',
            name: 'Tariff Plan',
            component: TariffPlan
        },
        {
            path: 'assistants',
            name: 'Assistants',
            component: AssistantsList
        },
        {
              path     : 'gifts',
              name     : 'Gifts',
              redirect: '/gifts/all-gifts',
              component: {
                  render (c) {
                      return c('router-view')
                  },
              },
              children: [
                  {
                      path      : 'all-gifts',
                      name      : 'GiftsList',
                      component : GiftsList
                  },
                  {
                      path      : 'create-gift',
                      name      : 'CreateGift',
                      component : CreateGift
                  },
                  {
                      path      : 'ordered-gifts',
                      name      : 'OrderedGifts',
                      component : OrderedGifts
                  }
              ],
        },
        {
            path: 'invoices',
            name: 'Invoices',
            redirect: '/invoices/all',
            component: {
                render (c) {
                    return c('router-view')
                },
            },
            children: [
                {
                    path: '/invoices/all',
                    name: 'InvoicesList',
                    component: InvoicesList
                },
                {
                    path: 'invoices/invoice-id-:id',
                    name: 'Invoice',
                    component: Invoice,
                    props: true
                }
            ]
        },
        {
            path: 'influencers',
            name: 'Influencers',
            component: InfluencersList
        },
        {
            path: 'new-assistant',
            name: 'CreateAssistant',
            component: CreateAssistant
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
                    path      : 'profile',
                    name      : 'Profile',
                    //component : ProfileP // performer
                    component : ProfileI // influencer
                }
            ]
        },
          // tmp
          {
              path      : '/profile-performer',
              name      : 'Profile',
              component : ProfileP // performer
          },
        {
            path: 'campaigns',
            redirect: '/campaigns/my-campaigns',
            name: 'Campaigns',
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
                },
                {
                  path       : 'add-new',
                  name       : 'AddNewCampaign',
                  component  : NewCompany
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
                            props: true,
                        },
                        {
                            path     : 'all-feedbacks',
                            name     : 'AllFeedbacks',
                            component: AllFeedbacks,
                        },
                    ]
                },
                {
                    path     : 'influencer-:id-bonuses',
                    name     : 'InfluencerBonuses',
                    component: InfluencerBonuses,
                    props: true,
                },
                {
                    path     : 'my-campaigns',
                    name     : 'MyCampaigns',
                    component: MyCampaigns,
                },
                {
                    path     : 'campaign-id-:id',
                    name     : 'Campaign',
                    component: Campaign,
                    props: true,
                },
                {
                    path     : 'results',
                    name     : 'Results',
                    redirect: '/campaigns/results/results-campaigns',
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
                        },
                        {
                            path     : 'result',
                            name     : 'ResultCampaign',
                            component: ResultCampign,
                            props: true,
                        },
                    ]
                },
            ],
        },
          // INFLUENCERS

        {
            path: 'offers',
            name: 'Offers',
            component: Offers
        },
        {
          path: 'invites',
          name: 'Invites',
          component: Invites
        },
        {
          path: 'points',
          name: 'Points',
          component: Points
        },
        {
          /* @todo change path */
          path: 'influencer-campaigns',
          name: 'CampaignsInfluencer',
          component: MyCampaignsI
        },
        {
          path: 'catalog-gifts',
          name: 'CatalogGifts',
          component: CatalogGifts
        },
        {
          path: 'my-gifts',
          name: 'MyGifts',
          component: MyGifts
        },
        {
          path     : 'profile-campaign-id-:id',
          name     : 'ProfileCampaign',
          component: ProfileCampaign,
          props: true,
        },
        {
          path     : 'influencer-id-:id',
          name     : 'Influencer',
          component: Influencer,
          props: true,
        },

          /// admin

        {
            path     : '/admin/',
            name     : 'Admin',
            redirect : 'admin/users',
            component: {
                render (c) { return c('router-view') },
            },
            children: [
                {
                    path      : '/admin/influencers',
                    name      : 'InfluencersAdmin',
                    component : InfluencersListAdmin
                },
                {
                    path      : '/admin/users',
                    name      : 'UsersAdmin',
                    component : UsersListAdmin
                },
            ]
        },


          /// default
        {
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
        },
      ],
    },
    {
      path     : '*',
      name     : '404',
      component: Page404,
    },
  ],
})
