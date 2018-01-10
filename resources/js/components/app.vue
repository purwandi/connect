<template lang="pug">
  .app-container
    app-sidebar
    .app-content
      app-navbar 
      router-view
</template>

<script>
import AppSidebar from '@/components/sidebar.vue'
import AppNavbar from '@/components/header.vue'
export default {
  name: "AppComponent",
  components: {
    AppSidebar, AppNavbar
  }
}
</script>

