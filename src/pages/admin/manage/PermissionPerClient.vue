<template>
  <article class="main">
    <div class="hgroup">
      <h1>Usuarios por Cliente</h1>
    </div>
    <section>
      <div class="container">
        <!-- Client selector -->
        <div class="control-group">
          <label>Cliente</label>
          <div class="controls">
            <multiselect
              v-model="selectedClient"
              :options="clients"
              label="socialReason"
              track-by="id"
              placeholder="Seleccionar cliente"
              class="client-select"
              @change="onClientChange"
            />
          </div>
        </div>

        <br />

        <!-- Table -->
        <table class="table table-striped table-bordered" v-if="users.length">
          <thead>
            <tr>
              <th class="span3">Usuario</th>
              <th>Permisos</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>
                <strong>{{ user.username }}</strong>
              </td>

              <td>
                <div v-for="perm in user.permissions" :key="perm.type" style="margin-bottom: 4px">
                  {{ perm.name }}
                  <small class="muted">({{ perm.description }})</small>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Empty -->
        <div v-else-if="selectedFolder" class="alert">No hay usuarios con permisos para este cliente</div>
      </div>
    </section>
  </article>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import { api } from '@/services/api'
import { AdminClient, UserWithPermissions } from '@/types/user'

// ================= STATE =================

const clients = ref<AdminClient[]>([])
const users = ref<UserWithPermissions[]>([])

const selectedFolder = ref('')

const selectedClient = ref<AdminClient | null>(null)

// ================= COMPUTED =================

// ================= LOGIC =================

onMounted(async () => {
  clients.value = await api.getAdminClients()
})

async function onClientChange() {
  if (!selectedClient.value) {
    users.value = []
    return
  }

  users.value = await api.getUsersPermissionsByClient(selectedClient.value.id)
}
</script>

<style>
.client-select {
  max-width: 500px;
}
</style>
