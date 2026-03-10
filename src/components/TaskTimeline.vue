<template>
  <div class="timeline">
    <div v-for="item in timeline" :key="item.id" class="timeline-item">
      <div class="timeline-marker"></div>

      <div class="timeline-content">
        <div class="timeline-header">
          <strong v-if="item.type !== 'file'">{{ item.owner }}</strong>
          <small class="muted">{{ formatDate(item.date) }}</small>
        </div>

        <div class="timeline-body">
          <template v-if="item.type === 'public'">
            {{ item.comment }}
          </template>

          <template v-if="item.type === 'file'">
            <span class="label label-inverse download-link" @click="downloadFile(item.id as number)">
              📎 {{ item.fileName }}
            </span>
          </template>

          <template v-if="item.type === 'response'">
            <span class="label label-important">Privado</span>
            {{ item.comment }}
          </template>
        </div>
      </div>
    </div>
  </div>
  <div class="add-comment">
    <h5>Agregar comentario</h5>

    <form @submit.prevent="submitComment">
      <textarea
        v-model="comment"
        class="input-block-level"
        rows="3"
        placeholder="Escribe un comentario..."
        required
      ></textarea>

      <button type="submit" class="btn btn-primary btn-small" :disabled="saving">
        {{ saving ? 'Enviando...' : 'Enviar comentario' }}
      </button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { api } from '@/services/api'
import { TaskTimeLine, UserTask } from '@/types/task'
import { user } from '@/auth'
interface Props {
  timeline: TaskTimeLine[]
  task: UserTask
}
const props = defineProps<Props>()

const timeline = ref<TaskTimeLine[]>(props.timeline)
const emit = defineEmits(['comment-added'])

const comment = ref('')
const isPrivate = ref(false)
const saving = ref(false)

function formatDate(date: string): string {
  return new Date(date).toLocaleDateString('es-UY', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
  })
}

async function downloadFile(fileId: number) {
  try {
    await api.getPublicTaskFile(props.task.id, fileId)
  } catch (e) {
    const err = e as Error
    if (err.message === 'FILE_NOT_FOUND') {
      alert('File not found')
    } else {
      alert('Error downloading file')
    }
  }
}
async function submitComment() {
  if (!comment.value.trim()) return

  saving.value = true

  try {
    await api.addCommentToTask(props.task.id, comment.value, user.value?.username || '')

    comment.value = ''

    emit('comment-added', props.task)
  } finally {
    saving.value = false
  }
}
</script>
<style>
.timeline {
  position: relative;
  margin-left: 20px;
  border-left: 2px solid #ddd;
  padding-left: 20px;
  max-height: 500px;
  overflow-y: auto;
}

.timeline-item {
  position: relative;
  margin-bottom: 20px;
}

.timeline-marker {
  position: absolute;
  left: -28px;
  top: 5px;
  width: 12px;
  height: 12px;
  background: #428bca;
  border-radius: 50%;
}

.timeline-content {
  background: #f9f9f9;
  padding: 10px;
  border-radius: 3px;
}

.timeline-header {
  margin-bottom: 5px;
}
.download-link {
  cursor: pointer;
}
</style>
