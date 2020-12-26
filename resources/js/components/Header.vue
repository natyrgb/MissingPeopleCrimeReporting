<template>
    <header class="masthead">
        <div class="container" id="app">
            <div class="masthead-subheading"></div>
            <div class="masthead-heading text-uppercase"></div>
            <router-link v-if="!isLoggedin"
                class="btn btn-primary btn-xl text-uppercase js-scroll-trigger"
                to="/api/register"
                >Register Here!</router-link
            >
        </div>
    </header>
</template>

<script>
export default {
    computed: {
        isLoggedIn : function(){ return this.$store.getters.isLoggedIn; }
    }
};
</script>
