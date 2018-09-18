<template>
    <div>
        <b-row>
            <b-col>
                <b-form-checkbox-group button-variant="primary" buttons v-model="selectedRole" name="btnsRoles" :options="optionsRoles" style="" class="groupRoles">
                </b-form-checkbox-group>
            </b-col>
        </b-row>

        <blogger v-if="selectedRole === 'blogger'"></blogger>
        <performer v-if="selectedRole === 'performer'"></performer>
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
                selectedRole: 'blogger',
                optionsRoles: [
                    {text: 'Blogger', value: 'blogger'},
                    {text: 'Performer', value: 'performer'},
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