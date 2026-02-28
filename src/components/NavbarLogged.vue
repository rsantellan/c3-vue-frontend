<template>
  <nav class="navbar">
    <div class="navbar-inner">
      <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
        <i class="menu-arrow"></i>
      </a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li :class="{ active: isActive('/admin/news') }">
            <router-link to="/admin/news">Noticias</router-link>
          </li>

          <li :class="{ active: isActive('/admin/accounts') }">
            <router-link to="/admin/accounts">Cuentas Corrientes</router-link>
          </li>

          <li :class="{ active: isActive('/admin/monthAmount') }">
            <router-link to="/admin/monthAmount">Importes del mes</router-link>
          </li>

          <li :class="{ active: isActive('/admin/yearExpiration') }">
            <router-link to="/admin/yearExpiration">Calendario anual</router-link>
          </li>

          <li class="dropdown" :class="{ active: isTasksActive }">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tarea</a>

            <ul class="dropdown-menu">
              <li :class="{ active: isActive('/admin/createTask') }">
                <router-link to="/admin/createTask">Crear tarea</router-link>
              </li>
              <li :class="{ active: isActive('/admin/viewTasks') }">
                <router-link to="/admin/viewTasks">Ver tarea</router-link>
              </li>
            </ul>
          </li>
        </ul>
        <ul class="nav pull-right">
          <li class="dropdown usermenu" :class="{ active: route.path.includes('/user') }">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              {{ fullName }}
              <i class="caret"></i>
            </a>

            <ul class="dropdown-menu">
              <li :class="{ active: isActive('/admin/user/profile') }">
                <router-link to="/admin/user/profile">Ver Perfil</router-link>
              </li>

              <li :class="{ active: isActive('/admin/user/profile/edit') }">
                <router-link to="/admin/user/profile/edit">Editar info. personal</router-link>
              </li>

              <li :class="{ active: isActive('/admin/user/profile/changepassword') }">
                <router-link to="/admin/user/profile/changepassword">Cambiar Contraseña</router-link>
              </li>

              <li class="divider"></li>

              <!-- 👇 ADMIN -->
              <template v-if="isAdmin && forceHidden">
                <li>
                  <router-link to="/admin/users">Listar Usuarios</router-link>
                </li>
                <li>
                  <router-link to="/admin/user/create">Nuevo Usuario</router-link>
                </li>
                <li>
                  <router-link to="/admin/permissions">Permisos</router-link>
                </li>
                <li>
                  <router-link to="/admin/business">Razones sociales</router-link>
                </li>
                <li class="divider"></li>
              </template>

              <!-- 👇 BOSS -->
              <template v-if="isBoss && forceHidden">
                <li>
                  <router-link to="/admin/boss">Listar Usuarios</router-link>
                </li>
                <li>
                  <router-link to="/admin/boss/create">Nuevo Usuario</router-link>
                </li>
                <li>
                  <router-link to="/admin/permissions">Permisos</router-link>
                </li>
                <li class="divider"></li>
              </template>

              <li>
                <a href="#" @click.prevent="logout">Cerrar sesión</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import { computed } from 'vue'
import { user, clearToken } from '@/auth'

const route = useRoute()
const router = useRouter()

function isActive(path) {
  return route.path === path
}

// 👇 user full name (replacement for Yii logic)
const fullName = computed(() => {
  if (!user.value) return ''

  if (user.value.firstName) {
    return `${user.value.firstName} ${user.value.lastName || ''}`
  }

  return user.value.username
})

const isAdmin = computed(() => user.value?.isAdmin)
const isBoss = computed(() => user.value?.isBoss)
const forceHidden = true
function logout() {
  clearToken()
  router.push('/login')
}

const isTasksActive = computed(() => {
  return ['/admin/createTask', '/admin/viewTasks'].some((path) => route.path.startsWith(path))
})
</script>
