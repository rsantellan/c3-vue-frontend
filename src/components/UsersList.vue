<script setup lang="ts">
import { ref, onMounted, computed, watch } from 'vue'
import type { User } from '@/types/user'

const props = defineProps<{
  fetchUsers: (params: { page: number; limit: number; search: string }) => Promise<{ users: User[]; total: number }>
  deleteUser: (id: number) => Promise<unknown>
  routes: {
    show: string
    edit: string
    permissions: string
  }
}>()

// ================= STATE =================

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

// ================= WATCH =================

watch(search, (value) => {
  if (timeout) clearTimeout(timeout)

  timeout = setTimeout(() => {
    debouncedSearch.value = value
  }, 400)
})

watch(debouncedSearch, () => {
  page.value = 1
  loadUsers()
})

// ================= LOGIC =================

async function loadUsers() {
  loading.value = true
  error.value = null

  try {
    const response = await props.fetchUsers({
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
  if (!date || date === '0000-00-00 00:00:00') return '-'
  return new Date(date).toLocaleString()
}

async function onDelete(user: User) {
  if (!confirm(`Eliminar usuario ${user.username}?`)) return

  errorUser.value = ''
  messageUser.value = ''

  try {
    await props.deleteUser(user.id)
    messageUser.value = `${user.username} eliminado con éxito`
    loadUsers()
  } catch (e) {
    errorUser.value = 'Error al eliminar el usuario'
  }
}

onMounted(loadUsers)
</script>

<template>
  <article class="main">
    <div class="hgroup">
      <h1>Usuarios</h1>
    </div>

    <!-- Search -->
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

    <!-- Messages -->
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
              <router-link class="view" :to="{ name: routes.show, params: { id: user.id } }">
                <i class="icon-eye-open"></i>
              </router-link>

              <router-link class="update" :to="{ name: routes.edit, params: { id: user.id } }">
                <i class="icon-pencil"></i>
              </router-link>

              <a class="delete" @click="onDelete(user)">
                <i class="icon-trash"></i>
              </a>

              <router-link class="permission" :to="{ name: routes.permissions, params: { id: user.id } }">
                <i class="icon-lock"></i>
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="pagination" v-if="totalPages > 1">
        <ul>
          <li :class="{ disabled: page === 1 }">
            <a href="#" @click.prevent="changePage(page - 1)">«</a>
          </li>

          <li v-for="p in totalPages" :key="p" :class="{ active: p === page }">
            <a href="#" @click.prevent="changePage(p)">
              {{ p }}
            </a>
          </li>

          <li :class="{ disabled: page === totalPages }">
            <a href="#" @click.prevent="changePage(page + 1)">»</a>
          </li>
        </ul>
      </div>
    </div>
  </article>
</template>
