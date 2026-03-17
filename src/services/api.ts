import router from '@/router'
import { clearToken } from '@/auth'
import { mapUser } from '@/mappers/userMapper'
import { mapClient } from '@/mappers/clientMapper'
import { mapAccounts } from '@/mappers/accountMapper'
import type { LoginResponse } from '@/types/auth'
import { ClientResponse } from '@/types/client'
import type { AccountsRequest, AccountsRangeRequest, AccountsResponse, NormalizedAccounts } from '@/types/accounts'

import type { MonthAmountResponse } from '@/types/monthAmount'
import { mapMonthAmount } from '@/mappers/monthAmountMapper'
import { ClientExpirationResponse } from '@/types/yearExpiration'
import { mapExpiration } from '@/mappers/yearExpirationMapper'
import { CreateTaskRequest, CreateTaskResponse, PublicTask, RetrieveUserTasksRequest, UserTask } from '@/types/task'
import { ChangePasswordPayload, UpdateProfilePayload } from '@/types/profile'

import type {
  UsersRequest,
  UsersResponse,
  User,
  AdminGroup,
  AdminClientApi,
  AdminUserForm,
  AdminPermissionType,
  UserPermissionResponse,
  UserPermissionApiResponse,
  UserPermissionApiRequest,
  UserWithPermissions,
} from '@/types/user'
import { mapApiUser, mapAdminClient } from '@/mappers/apiUserMapper'

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

async function download(endpoint: string, filename: string | null = null) {
  const response = await fetch(`${API_URL}${endpoint}`, {
    method: 'GET',
    headers: {
      ...getHeaders(),
    },
  })

  if (response.status === 401) {
    clearToken()

    if (router.currentRoute.value.path !== '/login') {
      router.push('/login')
    }

    throw new Error('UNAUTHORIZED')
  }

  if (response.status === 404) {
    throw new Error('FILE_NOT_FOUND')
  }

  if (!response.ok) {
    throw new Error(`HTTP ${response.status}`)
  }

  const blob = await response.blob()

  // try to get filename from header
  const disposition = response.headers.get('Content-Disposition')
  if (!filename && disposition) {
    const match = disposition.match(/filename="?([^"]+)"?/)
    console.log(match)
    if (match && match[1]) {
      filename = match[1]
    }
  }

  if (!filename) {
    filename = 'download'
  }

  const url = window.URL.createObjectURL(blob)

  const a = document.createElement('a')
  a.href = url
  a.download = filename
  document.body.appendChild(a)
  a.click()
  a.remove()

  window.URL.revokeObjectURL(url)
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

  retrieveAccountsRange(payload: AccountsRangeRequest) {
    return request('/account-data-date-range', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data) => {
      const result: Record<number, NormalizedAccounts> = {}
      console.log(data)
      Object.entries(data).forEach(([clientId, info]: any) => {
        if (!info.isvalid) return
        console.log(clientId)
        console.log(info)
        result[clientId] = mapAccounts(info.data)
      })

      return result
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

  getClientExpiration(clientId: number) {
    return request(`/get-client-expiration/${clientId}`, {
      method: 'GET',
    }).then((data: ClientExpirationResponse) => {
      if (!data.isvalid) {
        throw new Error('EXPIRATION_ERROR')
      }

      return {
        razonSocial: data.razonsocial,
        items: mapExpiration(data.data),
      }
    })
  },

  createTaskToClient(payload: CreateTaskRequest) {
    return request('/create-client-task', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: CreateTaskResponse) => {
      return data
    })
  },
  getPublicTasks() {
    return request('/get-public-available-tasks', {
      method: 'GET',
    }).then((data: PublicTask[]) => {
      return data
    })
  },

  getPublicTaskFile(taskId: number, fileId: number) {
    return download(`/${taskId}/${fileId}/get-public-task-file`)
  },

  retrieveUserCreatedClientTasks(payload: RetrieveUserTasksRequest) {
    return request('/retrieve-user-created-client-task', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: UserTask[]) => {
      return data
    })
  },
  getProfile() {
    return request('/profile', {
      method: 'GET',
    }).then((data: any) => {
      return {
        username: data.username,
        email: data.email,
        firstName: data.firstName,
        lastName: data.lastName,
        group: data.group,
        startingDate: data.startingDate,
        lastVisit: data.lastVisit,
        state: data.status,
      }
    })
  },

  getUserProfileById(id: number) {
    return request(`/admin/profile/${id}`, {
      method: 'GET',
    }).then((data: any) => {
      return {
        username: data.username,
        email: data.email,
        firstName: data.firstName,
        lastName: data.lastName,
        group: data.group,
        startingDate: data.startingDate,
        lastVisit: data.lastVisit,
        state: data.status,
      }
    })
  },

  getUserProfileByIdBoss(id: number) {
    return request(`/admin/profile-boss/${id}`, {
      method: 'GET',
    }).then((data: any) => {
      return {
        username: data.username,
        email: data.email,
        firstName: data.firstName,
        lastName: data.lastName,
        group: data.group,
        startingDate: data.startingDate,
        lastVisit: data.lastVisit,
        state: data.status,
      }
    })
  },

  updateProfile(payload: UpdateProfilePayload) {
    return request('/profile/update', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('UPDATE_PROFILE_ERROR')
      }

      return true
    })
  },

  updateUser(id: number, payload: UpdateProfilePayload) {
    return request(`/admin/profile-update/${id}`, {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('UPDATE_PROFILE_ERROR')
      }

      return true
    })
  },

  updateUserBoss(id: number, payload: UpdateProfilePayload) {
    return request(`/admin/boss-profile-update/${id}`, {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('UPDATE_PROFILE_ERROR')
      }

      return true
    })
  },

  changePassword(payload: ChangePasswordPayload) {
    return request('/profile/change-password', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('CHANGE_PASSWORD_ERROR')
      }

      return true
    })
  },

  getUsers(payload: UsersRequest): Promise<{ users: User[]; total: number }> {
    return request('/admin/users', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: UsersResponse) => {
      return {
        users: data.data.users.map(mapApiUser),
        total: Number(data.data.quantity),
      }
    })
  },

  removeUser(id: number) {
    return request(`/admin/profile/${id}`, {
      method: 'DELETE',
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('REMOVE_PROFILE_ERROR')
      }

      return true
    })
  },

  getUsersBoss(payload: UsersRequest): Promise<{ users: User[]; total: number }> {
    return request('/admin/users-boss', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: UsersResponse) => {
      return {
        users: data.data.users.map(mapApiUser),
        total: Number(data.data.quantity),
      }
    })
  },

  removeUserBoss(id: number) {
    return request(`/admin/profile-boss/${id}`, {
      method: 'DELETE',
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('REMOVE_PROFILE_ERROR')
      }

      return true
    })
  },

  getUserStatusOptions() {
    return [
      {
        code: 0,
        name: 'Inactivo',
      },
      {
        code: 1,
        name: 'Activo',
      },
      {
        code: -1,
        name: 'Bloqueado',
      },
    ]
  },

  getAdminGroups() {
    return request('/admin/get-groups', {
      method: 'GET',
    }).then((data: AdminGroup[]) => {
      return data
    })
  },

  getAdminClients() {
    return request('/admin/get-clients', {
      method: 'GET',
    }).then((data: AdminClientApi[]) => {
      return data.map(mapAdminClient)
    })
  },

  getAdminClientsBoss() {
    return request('/admin/boss-get-clients', {
      method: 'GET',
    }).then((data: AdminClientApi[]) => {
      return data.map(mapAdminClient)
    })
  },

  createUser(payload: AdminUserForm) {
    return request(`/admin/profile-create-user`, {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('CREATE_USER_ERROR')
      }
      return true
    })
  },

  createUserBoss(payload: AdminUserForm) {
    return request(`/admin/boss-profile-create-user`, {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('CREATE_USER_ERROR')
      }
      return true
    })
  },

  getPermissionTypes() {
    return request('/admin/get-permission-types', {
      method: 'GET',
    }).then((data: AdminPermissionType[]) => {
      return data
    })
  },

  getUserPermissions(id: number) {
    return request(`/admin/profile/permissions/${id}`, {
      method: 'GET',
    }).then((data: UserPermissionResponse) => {
      if (!data.success) {
        throw new Error('GET_USER_PERMISSION_ERROR')
      }
      return data.data
    })
  },

  getUserPermissionsBoss(id: number) {
    return request(`/admin/boss/profile/permissions/${id}`, {
      method: 'GET',
    }).then((data: UserPermissionResponse) => {
      if (!data.success) {
        throw new Error('GET_USER_PERMISSION_ERROR')
      }
      return data.data
    })
  },

  assignPermission(userId: number, type: string, folder: string) {
    const payload = {
      userId: userId,
      type: type,
      folder: folder,
    }
    return request('/admin/profile/permission/assign', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('ASSIGN_PROFILE_TO_USER_ERROR')
      }

      return true
    })
  },

  assignPermissionBoss(userId: number, type: string, folder: string) {
    const payload = {
      userId: userId,
      type: type,
      folder: folder,
    }
    return request('/admin/boss/profile/permission/assign', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('ASSIGN_PROFILE_TO_USER_ERROR')
      }

      return true
    })
  },

  removePermission(userId: number, type: string, folder: string) {
    const payload = {
      userId: userId,
      type: type,
      folder: folder,
    }
    return request('/admin/profile/permission/remove', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('REMOVE_ASSIGN_PROFILE_TO_USER_ERROR')
      }

      return true
    })
  },

  removePermissionBoss(userId: number, type: string, folder: string) {
    const payload = {
      userId: userId,
      type: type,
      folder: folder,
    }
    return request('/admin/boss/profile/permission/remove', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: any) => {
      if (!data.success) {
        throw new Error('REMOVE_ASSIGN_PROFILE_TO_USER_ERROR')
      }

      return true
    })
  },

  getUsersWithPermissions(payload: UserPermissionApiRequest) {
    return request('/admin/users-with-permissions', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: UserPermissionApiResponse) => {
      return data
    })
  },

  getUsersWithPermissionsBoss(payload: UserPermissionApiRequest) {
    return request('/admin/boss-users-with-permissions', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: UserPermissionApiResponse) => {
      return data
    })
  },

  getUsersPermissionsByClient(id: string) {
    return request(`/admin/users-permissions-by-client/${id}`, {
      method: 'GET',
    }).then((data: UserWithPermissions[]) => {
      return data
    })
  },

  addCommentToTask(taskId: number, comment: string, user: string) {
    const payload = { taskId: taskId, comment: comment, createdBy: user }
    return request('/add-comment-to-task', {
      method: 'POST',
      body: JSON.stringify(payload),
    }).then((data: any) => {
      return data
    })
  },
}
