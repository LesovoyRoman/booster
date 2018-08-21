<template>
    <div id="breadcrubms" v-if="this.$route.name !== 'overview'">
        <div class="content">
            <div class="breadcrumbs">
                <router-link :to="{path:'/admin'}">< Dashboard</router-link>
            </div>
            <transition name="fade" mode="out-in">
            </transition>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'breadcrubms',
    }
</script>
