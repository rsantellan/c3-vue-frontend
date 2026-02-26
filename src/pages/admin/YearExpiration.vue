<template>
  <article class="main">
    <div class="hgroup">
      <h1>Vencimientos en {{ currentYear }}</h1>
    </div>
    <div v-if="loading" class="loader">Cargando cuentas...</div>
    <div v-else-if="error">{{ error }}</div>
    <div v-else>
      <div v-for="(client, index) in results" :key="index">
        <!-- Title -->
        <h3 align="center" class="title-table-new">
          {{ client.razonSocial }}
        </h3>

        <div class="table-responsive">
          <table class="table calendar" width="100%">
            <!-- THEAD -->
            <thead>
              <tr>
                <th style="text-align: left" width="26">Calendario</th>
                <th width="26">Año</th>
                <th width="26">Ene</th>
                <th width="26">Feb</th>
                <th width="26">Mar</th>
                <th width="26">Abr</th>
                <th width="26">May</th>
                <th width="26">Jun</th>
                <th width="26">Jul</th>
                <th width="26">Ago</th>
                <th width="26">Sep</th>
                <th width="26">Oct</th>
                <th width="26">Nov</th>
                <th width="26">Dic</th>
              </tr>
            </thead>

            <!-- BODY -->
            <tbody>
              <tr v-for="(item, i) in client.items" :key="i">
                <td style="text-align: left">
                  <strong>{{ item.name }}</strong>
                </td>

                <td>{{ item.year }}</td>

                <td>{{ item.months.january }}</td>
                <td>{{ item.months.february }}</td>
                <td>{{ item.months.march }}</td>
                <td>{{ item.months.april }}</td>
                <td>{{ item.months.may }}</td>
                <td>{{ item.months.june }}</td>
                <td>{{ item.months.july }}</td>
                <td>{{ item.months.august }}</td>
                <td>{{ item.months.september }}</td>
                <td>{{ item.months.october }}</td>
                <td>{{ item.months.november }}</td>
                <td>{{ item.months.december }}</td>
              </tr>
            </tbody>

            <!-- repeat header like Yii -->
            <thead>
              <tr>
                <th style="text-align: left" width="26">Calendario</th>
                <th width="26">Año</th>
                <th width="26">Ene</th>
                <th width="26">Feb</th>
                <th width="26">Mar</th>
                <th width="26">Abr</th>
                <th width="26">May</th>
                <th width="26">Jun</th>
                <th width="26">Jul</th>
                <th width="26">Ago</th>
                <th width="26">Sep</th>
                <th width="26">Oct</th>
                <th width="26">Nov</th>
                <th width="26">Dic</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
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
            <div class="controls">
              <button class="btn btn-contact" type="submit">Buscar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </article>
</template>
<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { api } from '@/services/api'
import { clients } from '@/auth'

import type { NormalizedAccounts } from '@/types/accounts'

import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import { ClientExpiration } from '@/types/yearExpiration'

const accounts = ref<NormalizedAccounts | null>(null)
const loading = ref(false)
const error = ref<string | null>(null)
const selectedClients = ref<any[]>([])
const results = ref<ClientExpiration[]>([])

// filter clients
const allowedClients = computed(() => {
  return clients.value.filter((c) => c.permissions.monthAmount)
})

// extract ids
const clientIds = computed(() => {
  return allowedClients.value.map((c) => c.id)
})

const selectedClientIds = computed(() => selectedClients.value.map((c) => c.id))

const clientEntries = computed(() => accounts.value?.clients ?? [])
const now = new Date()

const month = ref<number>(now.getMonth() + 1)
const year = ref<number>(now.getFullYear())

const months = [
  'Enero',
  'Febrero',
  'Marzo',
  'Abril',
  'Mayo',
  'Junio',
  'Julio',
  'Agosto',
  'Septiembre',
  'Octubre',
  'Noviembre',
  'Diciembre',
]
const currentMonthName = computed(() => months[now.getMonth()])
const previousMonthName = computed(() => months[(now.getMonth() + 11) % 12])
const currentYear = now.getFullYear()

// FORMATTERS
function formatAmount(amount: number): string | number {
  if (!amount) return 0
  return new Intl.NumberFormat('es-UY', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(amount)
}

function formatDate(date: string): string {
  return new Date(date).toLocaleDateString('es-UY', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
  })
}

async function handleSearch() {
  if (!selectedClientIds.value.length) return

  loading.value = true
  error.value = null
  loadMultipleClients(selectedClientIds.value)
}

async function loadMultipleClients(clientIds: number[]) {
  loading.value = true
  results.value = []

  for (const clientId of clientIds) {
    try {
      const res = await api.getClientExpiration(clientId)

      results.value.push(res)
    } catch (e) {
      console.error(`Error loading client ${clientId}`, e)
    }
  }

  loading.value = false
}

// 👇 THIS is the key
watch(
  clientIds,
  (ids) => {
    loadMultipleClients(ids)
  },
  { immediate: true },
)
</script>
<style>
.loader {
  padding: 20px;
  text-align: center;
  font-weight: bold;
}
</style>
