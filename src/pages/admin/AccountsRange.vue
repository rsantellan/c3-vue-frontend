<template>
  <article class="main">
    <div class="hgroup">
      <h1>Buscar rango de fechas en cuentas</h1>
    </div>
    <div>
      <div v-if="allowedClients.length === 0">No hay clientes con permisos</div>
      <div v-else>
        <ul style="display: none">
          <li v-for="client in allowedClients" :key="client.id">
            {{ client.socialReason }} ({{ client.folderNumber }})
          </li>
        </ul>
        <form @submit.prevent="handleSearch" class="form-horizontal form-inline">
          <div class="control-group">
            <label class="control-label required">
              Razón Social
              <span class="required">*</span>
            </label>

            <div class="controls">
              <Multiselect
                v-model="selectedClients"
                :options="allowedClients"
                :multiple="true"
                label="socialReason"
                track-by="id"
                placeholder="Seleccione clientes"
              />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label required">Desde</label>

            <div class="controls">
              <input type="date" v-model="dateFrom" />
            </div>
          </div>

          <div class="control-group">
            <label class="control-label required">Hasta</label>

            <div class="controls">
              <input type="date" v-model="dateTo" />
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <button class="btn btn-contact" type="submit">Buscar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <template v-for="clientId in selectedClientIds" :key="clientId">
      <ClientAccountList v-if="accounts[clientId]" :accounts="accounts[clientId]" :client-id="clientId" />
    </template>
  </article>
</template>
<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { clients } from '@/auth'
import { api } from '@/services/api'

import ClientAccountList from '@/components/ClientAccountList.vue'

import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import { NormalizedAccounts } from '@/types/accounts'

const selectedClients = ref<any[]>([])

// filter clients
const allowedClients = computed(() => {
  return clients.value.filter((c) => c.permissions.currentAccountData)
})

const selectedClientIds = computed(() => selectedClients.value.map((c) => c.id))

// Date data
const now = new Date()

const month = ref<number>(now.getMonth() + 1)
const year = ref<number>(now.getFullYear())

function toIsoDate(date: Date): string {
  return date.toISOString().slice(0, 10)
}

const today = new Date()

const start = new Date(today)
start.setMonth(start.getMonth() - 12)

const end = new Date(today)
end.setMonth(end.getMonth() + 3)

const dateFrom = ref<string>(toIsoDate(start))
const dateTo = ref<string>(toIsoDate(end))

const loading = ref(false)
const error = ref<string | null>(null)

// Response data
const accounts = ref<Record<number, NormalizedAccounts>>({})

async function handleSearch() {
  if (!selectedClientIds.value.length) return
  loading.value = true

  try {
    accounts.value = await api.retrieveAccountsRange({
      clients: selectedClientIds.value,
      from: dateFrom.value,
      to: dateTo.value,
    })
  } finally {
    loading.value = false
  }
}

watch(
  allowedClients,
  (clients) => {
    if (clients.length && selectedClients.value.length === 0) {
      selectedClients.value = clients
    }
  },
  { immediate: true },
)
</script>
