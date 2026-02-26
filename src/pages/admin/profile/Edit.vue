<template>
  <article class="main">
    <div class="hgroup">
      <h1>Perfil de usuario</h1>
    </div>
    <section>
      <div class="container">
        <div v-if="message" class="alert alert-success">{{ message }}</div>
        <div v-if="error" class="alert alert-error">{{ error }}</div>

        <form @submit.prevent="submit" class="form-horizontal">
          <div class="control-group">
            <label class="control-label">Nombre</label>
            <div class="controls">
              <input v-model="form.firstName" type="text" />
            </div>
          </div>

          <div class="control-group">
            <label class="control-label">Apellido</label>
            <div class="controls">
              <input v-model="form.lastName" type="text" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Nombre de Usuario</label>
            <div class="controls">
              <input v-model="form.username" type="text" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Email</label>
            <div class="controls">
              <input v-model="form.email" type="email" />
            </div>
          </div>

          <div class="control-group">
            <div class="controls">
              <button class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </form>
      </div>
    </section>
  </article>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { api } from '@/services/api'
import { clearToken } from '@/auth'

const router = useRouter()

const form = ref({
  firstName: '',
  lastName: '',
  email: '',
  username: '',
})

const message = ref('')
const error = ref('')

onMounted(async () => {
  const profile = await api.getProfile()
  form.value = { ...profile }
})

function logout() {
  clearToken()
  router.push('/login')
}

async function submit() {
  try {
    await api.updateProfile(form.value)
    message.value = 'Perfil actualizado correctamente'
    logout()
  } catch (e) {
    error.value = 'Error actualizando perfil'
  }
}
</script>
