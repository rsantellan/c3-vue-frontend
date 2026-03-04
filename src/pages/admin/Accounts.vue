<template>
  <article class="main">
    <div class="hgroup">
      <h1>Cuentas entre {{ previousMonthName }} y {{ currentMonthName }} de {{ currentYear }}</h1>
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

          <div class="control-group" v-show="false">
            <div class="controls">
              <button class="btn btn-contact" type="submit">Buscar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <template v-for="clientId in selectedClientIds" :key="clientId">
      <ClientAccountList :id="clientId" :month="month" :year="year" />
    </template>
  </article>
</template>
<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { clients } from '@/auth'

import ClientAccountList from '@/components/ClientAccountList.vue'

import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'

const selectedClients = ref<any[]>([])

// filter clients
const allowedClients = computed(() => {
  return clients.value.filter((c) => c.permissions.currentAccountData)
})

const selectedClientIds = computed(() => selectedClients.value.map((c) => c.id))

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

async function handleSearch() {
  if (!selectedClientIds.value.length) return
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
