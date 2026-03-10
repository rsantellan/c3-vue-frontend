<template>
  <article class="main">
    <div class="hgroup">
      <h1>Crear tarea</h1>
    </div>

    <form class="form-horizontal" @submit.prevent="handleSubmit">
      <!-- TASK -->
      <div class="control-group">
        <label class="control-label">Tarea</label>
        <div class="controls">
          <select v-model="selectedTaskId" class="input-xlarge" required>
            <option disabled value="">Seleccione una tarea</option>
            <option v-for="task in tasks" :key="task.id" :value="task.id">
              {{ task.name }}
            </option>
          </select>
        </div>
      </div>

      <!-- CLIENT -->
      <div class="control-group">
        <label class="control-label">Cliente</label>
        <div class="controls">
          <select v-model="selectedClient" class="input-xlarge" required>
            <option disabled value="">Seleccione un cliente</option>
            <option v-for="client in allowedClients" :key="client.id" :value="client">
              {{ client.socialReason }} ({{ client.folderNumber }})
            </option>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label">Comentario</label>
        <div class="controls">
          <textarea v-model="comment" class="input-xlarge" required></textarea>
        </div>
      </div>
      <!-- SUBMIT -->
      <div class="control-group">
        <div class="controls">
          <button class="btn btn-primary" type="submit" :disabled="loading">
            <span v-if="loading">
              <i class="icon-refresh icon-white"></i>
              Creando...
            </span>
            <span v-else>Crear</span>
          </button>
        </div>
      </div>
    </form>

    <!-- ERROR -->
    <div v-if="error" class="alert alert-error" style="margin-top: 15px">
      <strong>Error:</strong>
      {{ error }}
    </div>

    <!-- SUCCESS -->
    <div v-if="result" class="alert alert-success" style="margin-top: 15px">
      <strong>Éxito:</strong>
      Tarea creada correctamente para el cliente
      <strong>{{ result.folder }}</strong>
    </div>
  </article>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { api } from '@/services/api'
import { user, clients } from '@/auth'
import type { PublicTask } from '@/types/task'
import type { CreateTaskResponse } from '@/types/task'

// state
const tasks = ref<PublicTask[]>([])
const selectedTaskId = ref<number | ''>('')
const selectedClient = ref<any | null>(null)
const comment = ref<string>('')

const loading = ref(false)
const error = ref<string | null>(null)
const result = ref<CreateTaskResponse | null>(null)

// clients from auth
const allowedClients = computed(() => {
  return clients.value
})

// load tasks
onMounted(async () => {
  try {
    tasks.value = await api.getPublicTasks()
  } catch {
    error.value = 'Error cargando tareas'
  }
})

// submit
async function handleSubmit() {
  if (!selectedTaskId.value || !selectedClient.value) return

  loading.value = true
  error.value = null
  result.value = null

  try {
    const response = await api.createTaskToClient({
      taskId: selectedTaskId.value,
      folder: selectedClient.value.folderNumber,
      createdBy: user.value?.username || '',
      comment: comment.value || '',
    })

    result.value = response
  } catch {
    error.value = 'Error creando la tarea'
  } finally {
    loading.value = false
  }
}
</script>
