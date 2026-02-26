<template>
  <article class="main">
    <div class="hgroup">
      <h1>Perfil de usuario</h1>
    </div>
    <section>
      <div v-if="message" class="alert alert-success">{{ message }}</div>
      <div v-if="error" class="alert alert-error">{{ error }}</div>

      <form @submit.prevent="submit" class="form-horizontal">
        <!-- Current password -->
        <div class="control-group">
          <label class="control-label">Contraseña actual</label>
          <div class="controls">
            <input v-model="form.currentPassword" type="password" />
          </div>
        </div>

        <!-- New password -->
        <div class="control-group">
          <label class="control-label">Nueva contraseña</label>
          <div class="controls">
            <input v-model="form.newPassword" type="password" />
          </div>
        </div>

        <!-- Confirm password -->
        <div class="control-group" :class="{ error: passwordMismatch }">
          <label class="control-label">Confirmar contraseña</label>
          <div class="controls">
            <input v-model="confirmPassword" type="password" />

            <!-- inline validation -->
            <span v-if="passwordMismatch" class="help-inline">Las contraseñas no coinciden</span>
          </div>
        </div>

        <!-- Submit -->
        <div class="control-group">
          <div class="controls">
            <button class="btn btn-primary" :disabled="passwordMismatch || !form.newPassword">
              Cambiar contraseña
            </button>
          </div>
        </div>
      </form>
    </section>
  </article>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { api } from '@/services/api'

const form = ref({
  currentPassword: '',
  newPassword: '',
})

const confirmPassword = ref('')

const message = ref('')
const error = ref('')

const passwordMismatch = computed(() => {
  return confirmPassword.value.length > 0 && form.value.newPassword !== confirmPassword.value
})

async function submit() {
  if (passwordMismatch.value) return
  try {
    await api.changePassword(form.value)
    message.value = 'Contraseña actualizada correctamente'
    form.value.currentPassword = ''
    form.value.newPassword = ''
    confirmPassword.value = ''
  } catch (e) {
    error.value = 'Error cambiando contraseña'
  }
}
</script>
