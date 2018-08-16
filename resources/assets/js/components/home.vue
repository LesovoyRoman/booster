<template>

    <div id="home">
        <div class="title m-b-md">
            Home
        </div>

        Welcome to Home
    </div>

</template>

<script>
    export default {
        name: 'home',
        created() {
            console.log(this.$parent.authenticated)
        },
        data() {
            return {
                auth: this.$root.authenticated
            }
        }
    }
</script>
