<template>
  <div id="app">
    <Navbar v-if="showNavbar" />
    <router-view />
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue'
import { useRoute } from 'vue-router'
import { computed } from 'vue'

export default {
  components: { Navbar },
  setup() {
    const route = useRoute()
    const showNavbar = computed(() => {
      return !['/login', '/register'].includes(route.path)
    })

    return { showNavbar }
  }
}
</script>
