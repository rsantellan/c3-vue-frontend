<template>
  <div class="container">
    <div id="wrapper-main">
      <template v-if="!isAuthenticated">
        <Header />
        <Navbar />
        <Carousel />
      </template>
      <template v-else>
        <HeaderSimple />
        <NavbarLogged />
      </template>
      <router-view />
    </div>
  </div>
  <Footer />
</template>

<script setup>
import { computed } from 'vue'
import Navbar from './components/Navbar.vue'
import NavbarLogged from './components/NavbarLogged.vue'
import Header from './components/Header.vue'
import HeaderSimple from './components/HeaderSimple.vue'
import Carousel from './components/Carousel.vue'
import Footer from './components/Footer.vue'
import { token } from './auth'

const isAuthenticated = computed(() => !!token.value)
</script>

<style></style>
