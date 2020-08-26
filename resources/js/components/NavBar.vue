<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
      <!-- <router-link to="/" class="navbar-brand"></router-link> -->
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li>
            <router-link to="/home" class="nav-link" exact-active-class="text-success" active-class="active">
              <font-awesome-icon :icon="['fas', 'home']" /> Home
            </router-link>
          </li>
          <li>
            <router-link to="/index" class="nav-link" exact-active-class="text-success" active-class="active">
              <font-awesome-icon :icon="['far', 'building']" /> Danh sách phòng họp
            </router-link>
          </li>

          <li>
            <router-link to="/create" class="nav-link" exact-active-class="text-success" active-class="active">
              <font-awesome-icon :icon="['fas', 'video']" /> Tạo phòng họp
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
export default {
}
</script>
<style></style>