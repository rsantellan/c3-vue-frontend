<template>
  <article class="main">
    <div class="hgroup">
      <h1>Usuarios</h1>
    </div>

    <div class="row-fluid" style="margin-bottom: 15px">
      <div class="span4">
        <input
          type="text"
          class="input-block-level"
          v-model="search"
          placeholder="Buscar por nombre, usuario o email..."
        />
      </div>
    </div>
    <div v-if="messageUser" class="alert alert-success">{{ messageUser }}</div>
    <div v-if="errorUser" class="alert alert-error">{{ errorUser }}</div>

    <!-- Loader -->
    <div v-if="loading" class="alert alert-info">Cargando...</div>

    <!-- Error -->
    <div v-else-if="error" class="alert alert-error">
      {{ error }}
    </div>

    <!-- Table -->
    <div v-else>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Último acceso</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.firstName }}</td>
            <td>{{ user.lastName }}</td>
            <td>{{ user.username }}</td>
            <td>{{ user.email }}</td>
            <td>{{ formatDate(user.lastVisit) }}</td>

            <td class="button-column">
              <router-link class="view" :to="{ name: 'admin-user-show', params: { id: user.id } }" title="Mostrar">
                <i class="icon-eye-open"></i>
              </router-link>
              <router-link class="update" :to="{ name: 'admin-user-edit', params: { id: user.id } }" title="Actualiza">
                <i class="icon-pencil"></i>
              </router-link>
              <a class="delete" title="Borrar" rel="tooltip" @click="deleteUser(user)">
                <i class="icon-trash"></i>
              </a>
              <a
                title="Editar Permisos"
                rel="tooltip"
                href="https://www.estudiocontable.com.uy/sitio/index.php/auth/assignment/view/id/49"
              >
                <i class="icon-lock"></i>
              </a>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="pagination" v-if="totalPages > 1">
        <ul>
          <!-- Prev -->
          <li :class="{ disabled: page === 1 }">
            <a href="#" @click.prevent="changePage(page - 1)">«</a>
          </li>

          <!-- Pages -->
          <li v-for="p in totalPages" :key="p" :class="{ active: p === page }">
            <a href="#" @click.prevent="changePage(p)">
              {{ p }}
            </a>
          </li>

          <!-- Next -->
          <li :class="{ disabled: page === totalPages }">
            <a href="#" @click.prevent="changePage(page + 1)">»</a>
          </li>
        </ul>
      </div>
    </div>
  </article>
</template>

<script setup lang="ts">
import { ref, onMounted, computed, watch } from 'vue'
import { api } from '@/services/api'
import type { User } from '@/types/user'

const users = ref<User[]>([])
const total = ref(0)
const loading = ref(false)
const error = ref<string | null>(null)

const messageUser = ref('')
const errorUser = ref('')

const page = ref(1)
const limit = 10
const totalPages = computed(() => Math.ceil(total.value / limit))

const search = ref('')
const debouncedSearch = ref('')

let timeout: ReturnType<typeof setTimeout> | null = null

watch(search, (value) => {
  if (timeout) clearTimeout(timeout)

  timeout = setTimeout(() => {
    debouncedSearch.value = value
  }, 400) // 300–500ms is ideal
})

watch(debouncedSearch, () => {
  page.value = 1 // reset pagination
  loadUsers()
})

async function loadUsers() {
  loading.value = true
  error.value = null

  try {
    const response = await api.getUsers({
      page: page.value,
      limit,
      search: debouncedSearch.value,
    })
    users.value = response.users
    total.value = response.total
  } catch (e) {
    error.value = 'Error cargando usuarios'
  } finally {
    loading.value = false
  }
}

function changePage(newPage: number) {
  if (newPage < 1 || newPage > totalPages.value) return
  page.value = newPage
  loadUsers()
}

function formatDate(date: string | null) {
  if (!date) return '-'
  if (date === '0000-00-00 00:00:00') return '-'
  //return date
  return new Date(date).toLocaleString()
}

async function deleteUser(user: User) {
  if (!confirm(`Eliminar usuario ${user.username}?`)) return
  errorUser.value = ''
  messageUser.value = ''
  try {
    const response = await api.removeUser(user.id)
    errorUser.value = ''
    messageUser.value = `${user.username} eliminado con exito`
    loadUsers()
  } catch (e) {
    console.log(e)
    errorUser.value = 'Error al eliminar el usuario'
  }
}

onMounted(loadUsers)
</script>
