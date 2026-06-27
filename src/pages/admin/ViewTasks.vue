<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { api } from '@/services/api'
import { user } from '@/auth'
import { RetrieveUserTasksRequest, TaskTimeLine, UserTask } from '@/types/task'
import TaskTimeline from '@/components/TaskTimeline.vue'

// ================= STATE =================
const tasks = ref<UserTask[]>([])
const loading = ref(false)
const error = ref<string | null>(null)
const expanded = ref<number | null>(null)

function formatDate(date: string): string {
  const [day, month, year] = date.split('/').map(Number)

  const parsedDate = new Date(year, month - 1, day)

  return parsedDate.toLocaleDateString('es-UY', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
  })
}
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

function toggle(task: UserTask) {
  if (expanded.value === task.id) return
  calculateTimeLine(task)
  expanded.value = task.id
}

function calculateTimeLine(task: UserTask) {
  const newTimeline: TaskTimeLine[] = []
  task.publicComment.forEach((comment) => {
    newTimeline.push({
      id: comment.id,
      fileName: '',
      owner: comment.owner,
      date: comment.date,
      type: 'public',
      comment: comment.comment,
    })
  })
  task.publicResponseComment.forEach((comment) => {
    newTimeline.push({
      id: comment.id,
      fileName: '',
      owner: comment.owner,
      date: comment.date,
      type: 'response',
      comment: comment.comment,
    })
  })
  task.files.forEach((album) => {
    album.files.forEach((file) => {
      newTimeline.push({
        id: file.id,
        fileName: file.name,
        owner: file.owner,
        date: file.date,
        type: 'file',
        comment: '',
      })
    })
  })
  newTimeline.sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime())

  task.timeline = newTimeline
}
async function commentAdded(task: UserTask) {
  await fetchTasks()
  const updatedTask = tasks.value.find((t) => t.id === task.id)

  if (updatedTask) {
    calculateTimeLine(updatedTask)
  }
  tasks.value = [...tasks.value]
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
    <table v-if="tasks.length" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Estado</th>
          <th>Inicio</th>
          <th>Actualización</th>
          <th>💬</th>
          <th>📎</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        <template v-for="task in tasks" :key="task.id">
          <tr>
            <td>{{ task.id }}</td>
            <td>{{ task.name }}</td>

            <td>
              <span class="label label-info">
                {{ task.status }}
              </span>
            </td>

            <td>{{ formatDate(task.startAt) }}</td>
            <td>{{ formatDate(task.updatedAt) }}</td>

            <td>{{ task.publicComment.length }}</td>
            <td>
              {{ task.files.reduce((total, group) => total + group.files.length, 0) }}
            </td>

            <td>
              <a class="btn btn-mini" @click="toggle(task)">Ver</a>
            </td>
          </tr>

          <!-- expanded row -->
          <tr v-if="expanded === task.id">
            <td colspan="8" v-if="task.timeline">
              <TaskTimeline :timeline="task.timeline" :task="task" @comment-added="commentAdded" />
            </td>
          </tr>
        </template>
      </tbody>
    </table>
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
