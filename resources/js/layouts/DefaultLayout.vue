<template>
  <div class="LayoutDefault">
    <h1>Live Video Call</h1>
    <nav-bar />
    <div class="container mt-2">
      <div class="row">
        <div class="col-md-12">
          <main class="LayoutDefault__main">
            <slot />
          </main>
        </div>
      </div>
    </div>
    <footer-bar />
  </div>
</template>

<script>

import NavBar from '../components/NavBar.vue'
import FooterBar from '../components/FooterBar.vue'

export default {
  components: {
    NavBar,
    FooterBar
  }
}
</script>
<style scoped>

</style>