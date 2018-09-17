<template>
    <b-nav-item-dropdown
            right
            no-caret>
        <template slot="button-content">
            <i class="icon-bell"/>
            <b-badge
                    pill
                    variant="danger">{{ allCount }}</b-badge>
        </template>
        <b-dropdown-item v-bind:to="'/invites'">
            <i class="fa fa-envelope-o"/> Invites
            <b-badge variant="info">{{ itemsCount }}</b-badge>

        </b-dropdown-item>

    </b-nav-item-dropdown>
</template>

<script>
    export default {
        name: 'HeaderDropdown',
        data: () => {
            return {
                itemsCount: 5,
                allCount: 5,

                invitesInbox: [
                    {id: 1, name: ''},
                ]
            }
        },
    }
</script>