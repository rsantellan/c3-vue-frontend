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
import { UserForm } from '@/types/user'

const props = defineProps<{
  loadUser: () => Promise<UserForm>
  saveUser: (data: UserForm) => Promise<boolean>
  logoutOnSave?: boolean
}>()

const emit = defineEmits<{
  (e: 'saved'): void
}>()

const form = ref<UserForm>({
  firstName: '',
  lastName: '',
  email: '',
  username: '',
})

const message = ref('')
const error = ref('')

onMounted(async () => {
  try {
    const profile = await props.loadUser()
    form.value = { ...profile }
  } catch (e) {
    error.value = 'Error cargando usuario'
  }
})

async function submit() {
  try {
    await props.saveUser(form.value)
    message.value = 'Perfil actualizado correctamente'
    emit('saved')
  } catch (e) {
    error.value = 'Error actualizando perfil'
  }
}
</script>
