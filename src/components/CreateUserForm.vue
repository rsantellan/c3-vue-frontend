<template>
  <article class="main">
    <div class="hgroup">
      <h1>Perfil de usuario</h1>
    </div>
    <section>
      <div class="container">
        <div v-if="message" class="alert alert-success">{{ message }}</div>
        <div v-if="error" class="alert alert-error">{{ error }}</div>
        <div class="form">
          <form @submit.prevent="submit" class="form-horizontal">
            <!-- Username -->
            <div class="control-group">
              <label class="control-label">Nombre de Usuario *</label>
              <div class="controls">
                <input v-model="form.username" type="text" />
              </div>
            </div>

            <!-- Email -->
            <div class="control-group">
              <label class="control-label">Correo electrónico *</label>
              <div class="controls">
                <input v-model="form.email" type="email" />
              </div>
            </div>

            <!-- Status -->
            <div class="control-group">
              <label class="control-label">Estado</label>
              <div class="controls">
                <select v-model="form.status">
                  <option v-for="status in statusOptions" :key="status.code" :value="status.code">
                    {{ status.name }}
                  </option>
                </select>
              </div>
            </div>

            <!-- Password -->
            <div class="control-group">
              <label class="control-label">Contraseña</label>
              <div class="controls">
                <input v-model="form.password" type="password" />
              </div>
            </div>

            <!-- Radio selection -->
            <div class="control-group" v-show="!props.forceClients">
              <div class="controls">
                <!-- Only show radios if NOT forced -->
                <template v-if="!props.forceClients">
                  <label class="radio">
                    <input type="radio" value="groups" v-model="selectionType" />
                    Grupos
                  </label>

                  <label class="radio">
                    <input type="radio" value="clients" v-model="selectionType" />
                    Razones Sociales libres
                  </label>
                </template>

                <!-- GROUP SELECT -->
                <select v-if="selectionType === 'groups' && !props.forceClients" v-model="form.group_id">
                  <option value="">---</option>
                  <option v-for="g in groups" :key="g.id" :value="g.id">
                    {{ g.name }}
                  </option>
                </select>

                <!-- CLIENT SELECT (always visible if forced) -->
                <select v-if="selectionType === 'clients' || props.forceClients" v-model="form.client_id">
                  <option value="">---</option>
                  <option v-for="c in clients" :key="c.id" :value="c.id">
                    {{ c.socialReason }}
                  </option>
                </select>
              </div>
            </div>

            <!-- First Name -->
            <div class="control-group">
              <label class="control-label">Nombres</label>
              <div class="controls">
                <input v-model="form.firstName" type="text" />
              </div>
            </div>

            <!-- Last Name -->
            <div class="control-group">
              <label class="control-label">Apellidos</label>
              <div class="controls">
                <input v-model="form.lastName" type="text" />
              </div>
            </div>

            <!-- Submit -->
            <div class="control-group">
              <div class="controls">
                <button class="btn btn-primary">Crear</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </article>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'
import type { AdminUserForm, AdminGroup, AdminClient } from '@/types/user'

type MaybePromise<T> = T | Promise<T>

interface Props {
  loadStatus: () => MaybePromise<{ code: number; name: string }[]>
  loadGroups: () => MaybePromise<AdminGroup[]>
  loadClients: () => MaybePromise<AdminClient[]>
  submitUser: (data: AdminUserForm) => Promise<boolean | void>
  forceClients?: boolean
}

const props = defineProps<Props>()

// ================= STATE =================

const form = ref<AdminUserForm>({
  username: '',
  email: '',
  status: 1,
  password: '',
  group_id: '',
  client_id: '',
  firstName: '',
  lastName: '',
})

const selectionType = ref<'groups' | 'clients'>(props.forceClients ? 'clients' : 'groups')

const message = ref('')
const error = ref('')

const statusOptions = ref<{ code: number; name: string }[]>([])
const groups = ref<AdminGroup[]>([])
const clients = ref<AdminClient[]>([])

// ================= INIT =================

onMounted(async () => {
  statusOptions.value = await props.loadStatus()
  if (!props.forceClients) {
    groups.value = await props.loadGroups()
  }
  clients.value = await props.loadClients()

  const active = statusOptions.value.find((s) => s.code === 1)
  if (active) {
    form.value.status = active.code
  }
})

// ================= WATCH =================

watch(selectionType, (val) => {
  if (val === 'groups') {
    form.value.client_id = ''
  } else {
    form.value.group_id = ''
  }
})

// ================= SUBMIT =================

async function submit() {
  try {
    error.value = ''
    message.value = ''
    await props.submitUser(form.value)
    message.value = 'Usuario creado correctamente'
  } catch (e) {
    error.value = e instanceof Error ? e.message : 'Error desconocido'
  }
}
</script>
