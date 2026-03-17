<template>
  <div>
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
</template>
<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { api } from '@/services/api'

import type { NormalizedAccounts } from '@/types/accounts'

interface Props {
  accounts: NormalizedAccounts
}
const props = defineProps<Props>()

const clientEntries = computed(() => props.accounts.clients ?? [])

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
</script>
<style>
.loader {
  padding: 20px;
  text-align: center;
  font-weight: bold;
}
</style>
