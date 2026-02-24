<template>
  <nav class="navbar">
    <div class="navbar-inner">
      <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
        <i class="menu-arrow"></i>
      </a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li :class="{ active: isActive('/') }">
            <router-link to="/">Inicio</router-link>
          </li>

          <li :class="{ active: isActive('/infraestructura') }">
            <router-link to="/infraestructura">Acerca de Nosotros</router-link>
          </li>

          <!-- Servicios dropdown -->
          <li class="dropdown" :class="{ active: isServiciosActive }">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Servicios</a>

            <ul class="dropdown-menu">
              <li :class="{ active: isActive('/contabilidad') }">
                <router-link to="/contabilidad">Contabilidad y Tributos</router-link>
              </li>

              <li :class="{ active: isActive('/seguridad') }">
                <router-link to="/seguridad">Seguridad Social y Laboral</router-link>
              </li>

              <li :class="{ active: isActive('/asesoramientos') }">
                <router-link to="/asesoramientos">Asesoramientos Especiales</router-link>
              </li>

              <li :class="{ active: isActive('/auditoria') }">
                <router-link to="/auditoria">Auditorías</router-link>
              </li>

              <li :class="{ active: isActive('/servicio-notarial') }">
                <router-link to="/servicio-notarial">Notarial y Real Estate</router-link>
              </li>
            </ul>
          </li>

          <li :class="{ active: isActive('/contacto') }">
            <router-link to="/contacto">Contacto</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { computed } from 'vue'

const route = useRoute()

function isActive(path) {
  return route.path === path
}
const isServiciosActive = computed(() => {
  return ['/contabilidad', '/seguridad', '/asesoramientos', '/auditoria', '/servicio-notarial'].some((path) =>
    route.path.startsWith(path),
  )
})
</script>
