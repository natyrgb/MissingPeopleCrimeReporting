<template>
    <header class="masthead">
        <div class="container" id="app">
            <div class="masthead-subheading">Missing People And Crime Reporting System</div>
            <div class="masthead-heading text-uppercase"></div>
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
