<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { api } from '@/services/api'
import { user } from '@/auth'
import { RetrieveUserTasksRequest, UserTask } from '@/types/task'

// ================= STATE =================
const tasks = ref<UserTask[]>([])
const loading = ref(false)
const error = ref<string | null>(null)

// ================= API =================
async function fetchTasks() {
  loading.value = true
  error.value = null

  try {
    const payload: RetrieveUserTasksRequest = {
      user: user.value?.username || '',
      all: false,
    }

    tasks.value = await api.retrieveUserCreatedClientTasks(payload)
  } catch (e) {
    error.value = 'Error cargando tareas'
  } finally {
    loading.value = false
  }
}

onMounted(fetchTasks)
</script>

<template>
  <article class="main">
    <div class="hgroup">
      <h1>Mis tareas</h1>
    </div>

    <!-- LOADING -->
    <div v-if="loading" class="alert alert-info">
      <i class="icon-refresh icon-spin"></i>
      Cargando tareas...
    </div>

    <!-- ERROR -->
    <div v-if="error" class="alert alert-error">
      <strong>Error:</strong>
      {{ error }}
    </div>

    <!-- EMPTY -->
    <div v-if="!loading && !tasks.length" class="alert">No hay tareas disponibles</div>

    <!-- TABLE -->
    <div v-if="tasks.length" class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Fecha inicio</th>
            <th>Última actualización</th>
            <th>Comentario</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in tasks" :key="task.id">
            <td>{{ task.id }}</td>
            <td>{{ task.name }}</td>
            <td>
              <span class="label label-info">{{ task.status }}</span>
            </td>
            <td>{{ task.startAt }}</td>
            <td>{{ task.updatedAt }}</td>
            <td>
              <span v-if="task.publicComment">{{ task.publicComment }}</span>
              <span v-else class="muted">Sin comentarios</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </article>
</template>

<style>
.icon-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
