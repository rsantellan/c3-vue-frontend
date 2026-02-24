import router from '@/router'
import { clearToken } from '@/auth'
import { mapUser } from '@/mappers/userMapper'
import { mapClient } from '@/mappers/clientMapper'
import { mapAccounts } from '@/mappers/accountMapper'
import type { LoginResponse } from '@/types/auth'
import { ClientResponse } from '@/types/client'
import type { AccountsRequest, AccountsResponse } from '@/types/accounts'

import type { MonthAmountResponse, NormalizedMonthAmount } from '@/types/monthAmount'
import { mapMonthAmount } from '@/mappers/monthAmountMapper'

const API_URL = import.meta.env.VITE_API_URL

function getHeaders(): HeadersInit {
  const token = localStorage.getItem('token')

  return {
    'Content-Type': 'application/json',
    ...(token ? { Authorization: `Bearer ${token}` } : {}),
  }
}

async function request(endpoint: string, options: RequestInit = {}) {
  const response = await fetch(`${API_URL}${endpoint}`, {
    ...options,
    headers: {
      ...getHeaders(),
      ...(options.headers || {}),
    },
  })

  let data: any = null

  try {
    data = await response.json()
  } catch (e) {
    // response without JSON
  }

  // 🔴 Handle 401 globally
  if (response.status === 401) {
    clearToken()

    // avoid infinite loop if already on login
    if (router.currentRoute.value.path !== '/login') {
      router.push('/login')
    }

    throw new Error('UNAUTHORIZED')
  }

  // HTTP error
  if (!response.ok) {
    throw new Error(data?.message || `HTTP ${response.status}`)
  }

  return data
}

export const api = {
  // 🔐 Auth
  login(username: string, password: string) {
    return request('/login', {
      method: 'POST',
      body: JSON.stringify({
        _username: username,
        _password: password,
      }),
    }).then((data: LoginResponse) => {
      if (!data.success) {
        throw new Error('INVALID_CREDENTIALS')
      }

      return {
        token: data.token,
        user: mapUser(data.user),
      }
    })
  },

  // 📰 Example admin endpoints
  getNews() {
    return request('/news')
  },

  getClients() {
    return request('/', {
      method: 'GET',
    }).then((data: ClientResponse) => {
      if (!data.success) {
        throw new Error('CLIENTS_ERROR')
      }

      return data.clients.map(mapClient)
    })
  },

  retrieveAccounts(payload: AccountsRequest) {
    return request('/retrieve-account-for-clients', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: AccountsResponse) => {
      if (!data.success) {
        throw new Error('ACCOUNTS_ERROR')
      }

      return mapAccounts(data.data)
    })
  },

  getClientMonthAmount(payload: { clientId: number; month: number; year: number }) {
    return request('/client-month-amount', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: MonthAmountResponse) => {
      if (!data.isvalid) {
        throw new Error('MONTH_AMOUNT_ERROR')
      }

      return mapMonthAmount(data)
    })
  },
}
