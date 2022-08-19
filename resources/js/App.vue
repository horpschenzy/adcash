<template>
  <div class="app">
    <router-view></router-view>
  </div>
</template>

<script>

export default {
  name: 'app',
  components: {
    Navbar: () => import('./Components/Navbar.vue')
  }
}
</script>