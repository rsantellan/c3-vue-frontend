<template>
  <article class="main">
    <div class="hgroup">
      <h1>Cuentas entre {{ previousMonthName }} y {{ currentMonthName }} de {{ currentYear }}</h1>
    </div>
    <div v-if="loading" class="loader">Cargando cuentas...</div>
    <div v-else-if="error">{{ error }}</div>
    <div v-else>
      <section v-if="accounts">
        <div class="table-list">
          <div class="item">
            <!-- TOTALS -->
            <div class="header">
              <table>
                <thead>
                  <tr>
                    <th></th>
                    <th>Totales</th>
                    <th></th>
                    <th>Saldo $</th>
                    <th></th>
                    <th>Saldo U$S</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ formatAmount(accounts.totals.SaldoPesos) }}</td>
                    <td></td>
                    <td>{{ formatAmount(accounts.totals.SaldoDolares) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <br />

            <!-- CLIENTS -->
            <div v-for="client in clientEntries" :key="client.name" class="item">
              <!-- CLIENT HEADER -->
              <div class="header">
                <table>
                  <thead>
                    <tr>
                      <th><i class="arrow"></i></th>
                      <th>{{ client.name }}</th>
                      <th></th>
                      <th>Saldo $</th>
                      <th></th>
                      <th>Saldo U$S</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>{{ formatAmount(client.subtotal.SaldoPesos) }}</td>
                      <td></td>
                      <td>{{ formatAmount(client.subtotal.SaldoDolares) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="content1">
                <!-- ACCOUNTS -->
                <div v-for="[accountName, account] in Object.entries(client.cuentas)" :key="accountName">
                  <h4>{{ accountName }}</h4>

                  <table>
                    <thead>
                      <tr>
                        <th>Fecha</th>
                        <th>Concepto</th>
                        <th>Importe $</th>
                        <th>Saldo $</th>
                        <th>Importe U$S</th>
                        <th>Saldo U$S</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- SALDO INICIAL -->
                      <tr>
                        <td></td>
                        <td>Saldo Inicial</td>
                        <td></td>
                        <td>{{ formatAmount(account.SaldoInicial.SaldoPesos) }}</td>
                        <td></td>
                        <td>{{ formatAmount(account.SaldoInicial.SaldoDolares) }}</td>
                      </tr>

                      <!-- MOVIMIENTOS -->
                      <tr v-for="(mov, index) in account.Movimientos" :key="index">
                        <td>{{ formatDate(mov.FECHA) }}</td>
                        <td>{{ mov.Documento }}</td>
                        <td>{{ formatAmount(mov.SaldoPesos) }}</td>
                        <td>{{ formatAmount(mov.AcumuladoPesos) }}</td>
                        <td>{{ formatAmount(mov.SaldoDolares) }}</td>
                        <td></td>
                      </tr>

                      <!-- SALDO FINAL -->
                      <tr>
                        <td></td>
                        <td>Saldo Final</td>
                        <td></td>
                        <td>{{ formatAmount(account.SaldoFinal.SaldoPesos) }}</td>
                        <td></td>
                        <td>{{ formatAmount(account.SaldoFinal.SaldoDolares) }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- END CLIENTS -->
          </div>
        </div>
      </section>
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

const accounts = ref<NormalizedAccounts | null>(null)
const loading = ref(false)
const error = ref<string | null>(null)
const selectedClients = ref<any[]>([])

// filter clients
const allowedClients = computed(() => {
  return clients.value.filter((c) => c.permissions.currentAccountData)
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

// load accounts
async function loadAccounts(ids: number[]) {
  if (!ids.length) return
  if (loading.value) return
  loading.value = true
  error.value = null

  try {
    accounts.value = await api.retrieveAccounts({
      clients: ids,
      month: month.value,
      year: year.value,
    })
  } catch (e) {
    error.value = 'Error cargando cuentas'
  } finally {
    loading.value = false
  }
}
async function handleSearch() {
  if (!selectedClientIds.value.length) return

  loading.value = true
  error.value = null

  try {
    accounts.value = await api.retrieveAccounts({
      clients: selectedClientIds.value,
      month: now.getMonth(),
      year: currentYear,
    })
  } catch (e) {
    error.value = 'Error cargando cuentas'
  } finally {
    loading.value = false
  }
}
// 👇 THIS is the key
watch(
  clientIds,
  (ids) => {
    loadAccounts(ids)
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
