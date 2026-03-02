<template>
  <article class="main">
    <div class="hgroup">
      <h1>Perfil de usuario</h1>
    </div>
    <section>
      <div class="container">
        <form @submit.prevent="assignPermission" class="form-inline">
          <select v-model="selectedClientFolder">
            <option value="">Seleccionar cliente</option>
            <optgroup v-for="group in groupedClients" :key="group.groupName" :label="group.groupName">
              <option v-for="client in group.clients" :key="client.id" :value="client.id">
                {{ client.socialReason }}
              </option>
            </optgroup>
          </select>

          <select v-model="selectedPermissionType">
            <option value="">Seleccionar permiso</option>
            <option v-for="p in permissionTypes" :key="p.name" :value="p.name" :disabled="isDisabled(p.name)">
              {{ p.description }}
            </option>
          </select>

          <button class="btn btn-primary">Asignar</button>
        </form>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Permiso</th>
              <th v-for="client in clientsWithPermissions" :key="client.id">
                {{ client.socialReason }}
              </th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="perm in permissionTypes" :key="perm.name">
              <td>{{ perm.description }}</td>

              <td v-for="client in clientsWithPermissions" :key="client.id">
                <button
                  v-if="hasPermission(perm.name, client.id)"
                  @click="removePermission(perm.name, client.id)"
                  class="btn btn-danger btn-sm"
                >
                  ✕
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </article>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { AdminPermissionType, AdminClient, UserPermission } from '@/types/user'

// ================= PROPS =================

interface Props {
  userId: number
  getPermissionTypes: () => Promise<AdminPermissionType[]>
  getClients: () => Promise<AdminClient[]>
  getUserPermissions: (userId: number) => Promise<UserPermission[]>
  assignPermission: (userId: number, type: string, folder: string) => Promise<boolean>
  removePermission: (userId: number, type: string, folder: string) => Promise<boolean>
}

const props = defineProps<Props>()

// ================= STATE =================

const permissionTypes = ref<AdminPermissionType[]>([])
const clients = ref<AdminClient[]>([])
const userPermissions = ref<UserPermission[]>([])

const selectedClientFolder = ref<string>('')
const selectedPermissionType = ref<string>('')

// ================= COMPUTED =================

const groupedClients = computed(() => {
  const map = new Map<string, { groupName: string; clients: AdminClient[] }>()

  for (const client of clients.value) {
    const key = client.groupId ? String(client.groupId) : 'no-group'
    const groupName = client.groupName || 'Sin grupo'

    if (!map.has(key)) {
      map.set(key, { groupName, clients: [] })
    }

    map.get(key)!.clients.push(client)
  }

  return Array.from(map.values())
})

const permissionSet = computed(() => {
  const set = new Set<string>()

  for (const p of userPermissions.value) {
    for (const d of p.data) {
      set.add(`${p.type}::${d.folder}`)
    }
  }

  return set
})

const clientsWithPermissions = computed(() => {
  const ids = new Set(userPermissions.value.flatMap((p) => p.data.map((d) => d.folder)))

  return clients.value.filter((c) => ids.has(String(c.id)))
})

// ================= METHODS =================

function hasPermission(permission: string, clientId: string) {
  return permissionSet.value.has(`${permission}::${clientId}`)
}

function isDisabled(permission: string) {
  if (!selectedClientFolder.value) return false

  return hasPermission(permission, selectedClientFolder.value)
}

async function refresh() {
  userPermissions.value = await props.getUserPermissions(props.userId)
}

async function assignPermission() {
  if (!selectedClientFolder.value || !selectedPermissionType.value) return

  await props.assignPermission(props.userId, selectedPermissionType.value, selectedClientFolder.value)

  await refresh()
}

async function removePermission(type: string, folder: string) {
  await props.removePermission(props.userId, type, folder)
  await refresh()
}

// ================= INIT =================

onMounted(async () => {
  permissionTypes.value = await props.getPermissionTypes()
  clients.value = await props.getClients()
  await refresh()
})
</script>
