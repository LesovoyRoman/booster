<template>
    <div>
        <b-row>
            <b-col>
                <b-form-checkbox-group button-variant="primary" buttons v-model="selectedRole" name="btnsRoles" :options="optionsRoles" style="" class="groupRoles">
                </b-form-checkbox-group>
            </b-col>
        </b-row>

        <blogger v-if="selectedRole === 2"></blogger>
        <performer v-if="selectedRole === 1"></performer>
    </div>
</template>

<script>
    let vm = {};
    import Blogger from './registerBlogger.vue'
    import Performer from './registerPerformer.vue'

    export default {
        name: 'Registration',
        data(){
            return {
                selectedRole: 2,
                optionsRoles: [
                    {text: 'Blogger', value: 2},
                    {text: 'Performer', value: 1},
                ]
            }
        },
        components: {
            Blogger,
            Performer
        },
        created(){

        },
        methods: {

        }
    }
</script>