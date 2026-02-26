<template>
  <article class="main">
    <div class="hgroup">
      <h1>Perfil de usuario</h1>
    </div>
    <section>
      <div class="container">
        <h3>Perfil de usuario</h3>

        <div v-if="loading" class="alert alert-info">Cargando...</div>
        <div v-if="error" class="alert alert-error">{{ error }}</div>

        <table v-if="profile" class="table table-bordered">
          <tr>
            <th>Usuario</th>
            <td>{{ profile.username }}</td>
          </tr>
          <tr>
            <th>Email</th>
            <td>{{ profile.email }}</td>
          </tr>
          <tr>
            <th>Nombre</th>
            <td>{{ profile.firstName }}</td>
          </tr>
          <tr>
            <th>Apellido</th>
            <td>{{ profile.lastName }}</td>
          </tr>
          <tr>
            <th>Grupo</th>
            <td>{{ profile.group }}</td>
          </tr>
          <tr>
            <th>Fecha de creación</th>
            <td>{{ profile.startingDate }}</td>
          </tr>
          <tr>
            <th>Ultima visita</th>
            <td>{{ profile.updatedDate }}</td>
          </tr>
          <tr>
            <th>Estado</th>
            <td>{{ profile.state }}</td>
          </tr>
        </table>
      </div>
    </section>
  </article>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { api } from '@/services/api'
import type { UserProfile } from '@/types/profile'

const profile = ref<UserProfile | null>(null)
const loading = ref(false)
const error = ref<string | null>(null)

onMounted(async () => {
  loading.value = true
  try {
    profile.value = await api.getProfile()
  } catch (e) {
    console.log(e)
    error.value = 'Error cargando perfil'
  } finally {
    loading.value = false
  }
})
</script>
