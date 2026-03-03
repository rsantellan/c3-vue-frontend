<template>
  <article class="main">
    <div class="hgroup">
      <h1>{{ title }}</h1>
    </div>

    <section>
      <div class="container">
        <!-- Search -->
        <div class="row-fluid" style="margin-bottom: 15px">
          <div class="span4">
            <input v-model="search" @input="onSearch" :placeholder="searchPlaceholder" class="form-control" />
          </div>
        </div>

        <!-- Table -->
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Usuario</th>
              <th>Permisos</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>
                <router-link class="update" :to="getUserLink(user.id)" title="Actualiza">
                  {{ user.username }}
                </router-link>
              </td>

              <td>
                <div v-if="user.permissions.length">
                  <div v-for="perm in user.permissions" :key="perm.type">
                    {{ perm.name }}
                    <small class="text-muted">{{ perm.description }}</small>
                  </div>
                </div>

                <span v-else class="text-muted">Sin permisos</span>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
          <button class="btn btn-sm" :disabled="page === 1" @click="changePage(page - 1)">←</button>

          <span class="mx-2">Página {{ page }}</span>

          <button class="btn btn-sm" :disabled="page >= totalPages" @click="changePage(page + 1)">→</button>
        </div>
      </div>
    </section>
  </article>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'

// ================= PROPS =================

const props = defineProps<{
  title: string
  searchPlaceholder?: string
  fetchFunction: (params: { page: number; perPage: number; search: string }) => Promise<any>
  getUserLink: (id: number) => any
}>()

// ================= STATE =================

const users = ref<any[]>([])
const page = ref(1)
const perPage = ref(10)
const total = ref(0)
const search = ref('')

// ================= COMPUTED =================

const totalPages = computed(() => Math.ceil(total.value / perPage.value))

// ================= LOGIC =================

let searchTimeout: number | undefined

async function fetchUsers() {
  const response = await props.fetchFunction({
    page: page.value,
    perPage: perPage.value,
    search: search.value,
  })

  users.value = response.data
  total.value = response.pagination.total
}

function changePage(newPage: number) {
  page.value = newPage
  fetchUsers()
}

function onSearch() {
  page.value = 1

  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(fetchUsers, 300)
}

onMounted(fetchUsers)
</script>
