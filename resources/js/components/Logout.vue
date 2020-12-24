<template>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    created() {
        this.logout();
    },
    methods: {
        logout: function () {
            this.$store.dispatch('logout')
            .then(() => {
                this.$forceUpdate()
                this.$router.push('/api/login')
            })
        }
    }
};
</script>
