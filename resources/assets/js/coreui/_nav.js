export default {
  items: [
      {
          name : 'Add new campaign',
          url  : '/campaigns/add-new',
          icon : 'icon-plus',
          variant: 'primary'
      },
    {
      name : 'Dashboard',
      url  : '/dashboard',
      icon : 'icon-speedometer',
    },
    {
      title  : true,
      name   : 'Theme',
      class  : '',
      wrapper: {
        element   : '',
        attributes: {},
      },
    },
    /*{
      name: 'Colors',
      url : '/theme/colors',
      icon: 'icon-drop',
    },*/
    /*{
      name: 'Typography',
      url : '/theme/typography',
      icon: 'icon-pencil',
    },*/
    {
      title  : true,
      name   : 'Components',
      class  : '',
      wrapper: {
        element   : '',
        attributes: {},
      },
    },
      {
          name    : 'Campaigns',
          url     : '/campaigns',
          icon    : 'icon-globe',
          children: [
              {
                  name      : 'Checking bonuses',
                  url       : '/campaigns/checking-bonuses',
                  icon      : 'icon-check',
              },
              {
                  url       : '/campaigns/feedbacks',
                  name      : 'Feedbacks',
                  icon      : 'icon-feed',
              },
              /*{
                  url       : '/campaigns/influencers-bonuses',
                  name      : 'Influencers bonuses',
                  icon      : 'icon-present',
              },*/
              {
                  url       : '/campaigns/my-campaigns',
                  name      : 'My campaigns',
                  icon      : 'icon-briefcase',
              },
              {
                  url       : '/campaigns/results/results-campaigns',
                  name      : 'Results campaigns',
                  icon      : 'icon-chart',
              },
          ]
    },
    {
        name  : 'Profile Performer',
        url   : '/profile-performer',
        icon  : 'fa fa-user-circle'
    },
    {
      name    : 'Tariffs',
      url     : '/tariffs',
      icon    : 'fa fa-credit-card-alt',
    },
    {
      name    : 'Assistants',
      url     : '/assistants',
      icon    : 'fa fa-id-card-o'
    },
    {
      name    : 'Influencers',
      url     : '/influencers',
      icon    : 'fa fa-address-book-o'
    },
    {
        name    : 'Gifts',
        url     : '/gifts',
        icon    : 'fa fa-gift',
        children: [
            {
                url       : '/gifts/all-gifts',
                name      : 'GiftsList',
                icon      : 'fa fa-th-list'
            },
            {
                url       : '/gifts/create-gift',
                name      : 'CreateGift',
                icon      : 'fa fa-folder-open'
            },
            {
                url       : '/gifts/ordered-gifts',
                name      : 'OrderedGifts',
                icon      : 'fa fa-spin fa-circle-o-notch'
            }
        ],
    },
    {
        url       : '/invoices/all',
        name      : 'Invoices',
        icon      : 'fa fa-external-link',
    },

      /// influencers
    {
        url       : '/offers',
        name      : 'Offers',
        icon      : 'fa fa-bullhorn'
    },
    {
      url       : '/invites',
      name      : 'Invites',
      icon      : 'fa fa-user-plus'
    },
    {
      url       : '/points',
      name      : 'Points',
      icon      : 'fa fa-trophy'
    },
    {
      /* @todo change url & name */
      url       : '/influencer-campaigns',
      name      : 'My Campaigns',
      icon      : 'fa fa-calendar-check-o'
    },
    {
      url       : '/catalog-gifts',
      name      : 'Catalog Gifts',
      icon      : 'fa fa-gift'
    },
    {
      url       : '/my-gifts',
      name      : 'My Gifts',
      icon      : 'fa fa-gift'
    },


      /// admin
      {
          name    : 'Admin',
          url     : '/admin/',
          icon    : 'fa fa-user-circle-o',
          children: [
              {
                  url       : '/admin/influencers',
                  name      : 'InfluencersAdmin',
                  icon      : 'fa fa-group'
              },
              {
                  url       : '/admin/users',
                  name      : 'UsersAdmin',
                  icon      : 'fa fa-address-book'
              },
          ],
      },

    /*{
      name    : 'Base',
      url     : '/base',
      icon    : 'icon-puzzle',
      children: [
        {
          name: 'Breadcrumbs',
          url : '/base/breadcrumbs',
          icon: 'icon-puzzle',
        },
        {
          name: 'Cards',
          url : '/base/cards',
          icon: 'icon-puzzle',
        },
        {
          name: 'Carousels',
          url : '/base/carousels',
          icon: 'icon-puzzle',
        },
        {
          name: 'Collapses',
          url : '/base/collapses',
          icon: 'icon-puzzle',
        },
        {
          name: 'Forms',
          url : '/base/forms',
          icon: 'icon-puzzle',
        },
        {
          name: 'Jumbotrons',
          url : '/base/jumbotrons',
          icon: 'icon-puzzle',
        },
        {
          name: 'List Groups',
          url : '/base/list-groups',
          icon: 'icon-puzzle',
        },
        {
          name: 'Navs',
          url : '/base/navs',
          icon: 'icon-puzzle',
        },
        {
          name: 'Paginations',
          url : '/base/paginations',
          icon: 'icon-puzzle',
        },
        {
          name: 'Popovers',
          url : '/base/popovers',
          icon: 'icon-puzzle',
        },
        {
          name: 'Progress Bars',
          url : '/base/progress-bars',
          icon: 'icon-puzzle',
        },
        {
          name: 'Switches',
          url : '/base/switches',
          icon: 'icon-puzzle',
        },
        {
          name: 'Tables',
          url : '/base/tables',
          icon: 'icon-puzzle',
        },
        {
          name: 'Tooltips',
          url : '/base/tooltips',
          icon: 'icon-puzzle',
        },
      ],
    },
    {
      name    : 'Buttons',
      url     : '/buttons',
      icon    : 'icon-cursor',
      children: [
        {
          name: 'Standard Buttons',
          url : '/buttons/standard-buttons',
          icon: 'icon-cursor',
        },
        {
          name: 'Button Groups',
          url : '/buttons/button-groups',
          icon: 'icon-cursor',
        },
        {
          name: 'Dropdowns',
          url : '/buttons/dropdowns',
          icon: 'icon-cursor',
        },
        {
          name: 'Social Buttons',
          url : '/buttons/social-buttons',
          icon: 'icon-cursor',
        },
      ],
    },
    {
      name    : 'Icons',
      url     : '/icons',
      icon    : 'icon-star',
      children: [
        {
          name : 'Flags',
          url  : '/icons/flags',
          icon : 'icon-star',
          badge: {
            variant: 'success',
            text   : 'NEW',
          },
        },
        {
          name : 'Font Awesome',
          url  : '/icons/font-awesome',
          icon : 'icon-star',
          badge: {
            variant: 'secondary',
            text   : '4.7',
          },
        },
        {
          name: 'Simple Line Icons',
          url : '/icons/simple-line-icons',
          icon: 'icon-star',
        },
      ],
    },
    {
      name: 'Charts',
      url : '/charts',
      icon: 'icon-pie-chart',
    },
    {
      name    : 'Notifications',
      url     : '/notifications',
      icon    : 'icon-bell',
      children: [
        {
          name: 'Alerts',
          url : '/notifications/alerts',
          icon: 'icon-bell',
        },
        {
          name: 'Badges',
          url : '/notifications/badges',
          icon: 'icon-bell',
        },
        {
          name: 'Modals',
          url : '/notifications/modals',
          icon: 'icon-bell',
        },
      ],
    },
    {
      name : 'Widgets',
      url  : '/widgets',
      icon : 'icon-calculator',
      badge: {
        variant: 'primary',
        text   : 'NEW',
      },
    },
    {
      name : 'Loading',
      url  : '/loading',
      icon : 'icon-reload',
      badge: {
        variant: 'danger',
        text   : 'HOT',
      },
    },
    {
      divider: true,
    },
    {
      title: true,
      name : 'Extras',
    },
    {
      name    : 'Pages',
      url     : '/pages',
      icon    : 'icon-star',
      children: [
        {
          name: 'Login',
          url : '/pages/login',
          icon: 'icon-star',
        },
        {
          name: 'Register',
          url : '/pages/register',
          icon: 'icon-star',
        },
        {
          name: 'Error 404',
          url : '/pages/404',
          icon: 'icon-star',
        },
        {
          name: 'Error 500',
          url : '/pages/500',
          icon: 'icon-star',
        },
      ],
    },*/
  ],
}
