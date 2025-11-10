<template>
  <div class="min-h-screen flex flex-col">
    <header>
      <div class="wrapper">
        <UserNavbar />
      </div>
    </header>
    <main class="flex-grow bg--beige pt-16">
      <RouterView />
    </main>
    <footer>
      <UserFooter />
    </footer>
  </div>
</template>

<script lang="ts">
import UserNavbar from '@/components/users/userLayout/UserNavbar.vue'
import UserFooter from '@/components/users/userLayout/UserFooter.vue'
import { RouterView } from 'vue-router'

export default {
  components: {
    UserNavbar,
    UserFooter,
    RouterView,
  },
}
</script>
