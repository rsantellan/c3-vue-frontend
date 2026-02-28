<template>
  <article class="main">
    <div class="hgroup">
      <h1>Perfil de usuario</h1>
    </div>
    <section>
      <div class="container">
        <div v-if="loading" class="alert alert-info">Cargando...</div>
        <div v-if="error" class="alert alert-error">{{ error }}</div>

        <table v-if="profile" class="table table-bordered">
          <tbody>
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
              <td>{{ profile.lastVisit }}</td>
            </tr>
            <tr>
              <th>Estado</th>
              <td>{{ profile.state }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </article>
</template>

<script setup lang="ts">
import type { UserProfile } from '@/types/profile'

defineProps<{
  profile: UserProfile | null
  loading?: boolean
  error?: string | null
}>()
</script>
