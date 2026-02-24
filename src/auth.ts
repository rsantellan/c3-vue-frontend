import { ref } from 'vue'
import { Client } from './types/client'

export const token = ref<string | null>(localStorage.getItem('token'))

export const user = ref<any>(localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user') as string) : null)

export const clients = ref<Client[]>(
  localStorage.getItem('clients') ? JSON.parse(localStorage.getItem('clients') as string) : [],
)

export function setAuth(newToken: string, userData: any) {
  token.value = newToken
  user.value = userData

  localStorage.setItem('token', newToken)
  localStorage.setItem('user', JSON.stringify(userData))
}

export function clearToken() {
  token.value = null
  user.value = null

  localStorage.removeItem('token')
  localStorage.removeItem('user')
  clearClients()
}

export function setClients(data: Client[]) {
  clients.value = data
  localStorage.setItem('clients', JSON.stringify(data))
}

export function clearClients() {
  clients.value = []
  localStorage.removeItem('clients')
}
