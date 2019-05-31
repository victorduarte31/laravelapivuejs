<template>
    <div>
        <header-site></header-site>

        <router-view></router-view>

        <footer-site></footer-site>
    </div>
</template>

<script>
    import FooterComponent from "./FooterComponent";
    import HeaderComponent from "./HeaderComponent";

    export default {
        components: {
            footerSite: FooterComponent,
            headerSite: HeaderComponent,
        }
    }
</script>

<style scoped>

</style>
