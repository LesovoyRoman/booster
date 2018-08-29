<template>

    <div id="navVue">
        <header>
            <b-link
                    class="navbar-brand"
                    to="#"/>
            <button id="btn_call_menu_custom"
                    class="navbar-toggler aside-menu-toggler d-md-down-none btn-primary"
                    type="button"
                    @click="asideToggle">
                <span class=""><i class="fa fa-bars fa-1x"></i></span>
            </button>
        </header>
    </div>

</template>

<script>
    let vm = {};

    export default {
        name: 'navVue',
        methods: {
            logout: function() {

                return axios.post('/logout',
                    {

                    }).then(response => {
                        this.$root.statusAuth(false, '/login');
                    })
                    .catch(error => {
                        console.log('logout error-> ', error.response);
                        vmThis.$root.updateCrsf();
                    });
            },
            asideToggle (e) {
                e.preventDefault()
                document.getElementById('bg_app').classList.toggle('open')
                document.getElementById('app').classList.toggle('open')
            },
        },
        created(){
            vm = this;
        },
        watch:{
            $route (to, from){
                vm.asideToggle(event);
            }
        }
    }
</script>