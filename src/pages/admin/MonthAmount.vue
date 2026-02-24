<template>
  <article class="main">
    <div class="hgroup">
      <h1>Importes para {{ currentMonthName }} {{ currentYear }}</h1>
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
    <section>
      <div v-if="loading">Cargando...</div>
      <div v-else-if="error">{{ error }}</div>

      <template v-else-if="results.length">
        <hr />

        <template v-for="clientData in results" :key="clientData.client.id">
          <div :id="'client_' + clientData.client.id">
            <h3>{{ clientData.client.razonsocial }}</h3>

            <div :id="'client_data_' + clientData.client.id">
              <div v-for="calendar in clientData.calendar" :key="calendar.id" class="title_client_amount">
                <h4 class="title_amounth">
                  <!-- Arrow -->
                  <a class="arrow" href="#" @click.prevent="toggle(calendar.id)"></a>

                  <!-- Name -->
                  <div class="title_amounth_blue">
                    {{ calendar.name }}
                  </div>
                  <!-- Total -->
                  <div class="total_amounth_blue" v-if="calendar.payments.length">
                    <template v-if="Number(calendar.payments[0].amountWithTaxes) === 0">
                      Importe aún no definido
                    </template>
                    <template v-else>Total: ${{ calendar.payments[0].amountWithTaxes }}</template>
                  </div>

                  <!-- Date -->
                  <div class="date_amounth_blue" v-if="calendar.month">
                    - Vence el {{ calendar.month }} de {{ currentMonthName }} -
                  </div>
                </h4>

                <!-- Detail -->
                <div v-show="openItems[calendar.id]" class="content_amounth">
                  <template v-if="calendar.payments?.length && calendar.payments[0]?.taxes?.length">
                    <table class="table no-margin header-grey">
                      <thead>
                        <tr>
                          <th>Concepto</th>
                          <th>Importe $</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(tax, i) in calendar.payments[0].taxes" :key="i">
                          <td>{{ tax.name }}</td>
                          <td>{{ tax.amount }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </template>

                  <template v-else>
                    <h6>No hay información</h6>
                  </template>
                </div>

                <hr />
              </div>
            </div>
          </div>
        </template>
      </template>
    </section>
  </article>
</template>
<script setup lang="ts">
import { ref, computed } from 'vue'
import type { ClientMonthData } from '@/types/monthAmount'
import { clients } from '@/auth'
import { api } from '@/services/api'

import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'

const results = ref<ClientMonthData[]>([])
const loading = ref(false)
const error = ref<string | null>(null)

const openItems = ref<Record<number, boolean>>({})

function toggle(id: number) {
  openItems.value[id] = !openItems.value[id]
}

const selectedClients = ref<any[]>([])

const selectedClientIds = computed(() => selectedClients.value.map((c) => c.id))

// filter clients
const allowedClients = computed(() => {
  return clients.value.filter((c) => c.permissions.currentAccountData)
})

// extract ids
const clientIds = computed(() => {
  return allowedClients.value.map((c) => c.id)
})

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
const now = new Date()
const currentMonth = now.getMonth() + 1
const currentMonthName = computed(() => months[now.getMonth()])
const currentYear = now.getFullYear()
console.log(currentMonth)
async function handleSearch() {
  if (!selectedClientIds.value.length) return

  results.value = []
  loadMultipleClients(selectedClientIds.value, currentMonth, currentYear)
}

async function loadMultipleClients(clientIds: number[], month: number, year: number) {
  loading.value = true
  results.value = []

  for (const clientId of clientIds) {
    try {
      const res = await api.getClientMonthAmount({
        clientId,
        month,
        year,
      })

      results.value.push(...res.clients)
    } catch (e) {
      console.error(`Error loading client ${clientId}`, e)
    }
  }

  loading.value = false
}
</script>
<style>
.loader {
  padding: 20px;
  text-align: center;
  font-weight: bold;
}
</style>
