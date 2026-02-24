export interface ApiUserChild {
  username: string
  email: string
  status: string
  superuser: string
  group_id: string
  client_id: string | null
  first_name: string
  last_name: string
}

export interface ApiUser {
  username: string
  group: string
  boss: string
  superuser: string
  firstName: string
  lastName: string
  children?: ApiUserChild[]
}

export interface LoginResponse {
  success: boolean
  error: string
  token: string
  user: ApiUser
}

// 👇 your frontend model (cleaned & normalized)
export interface UserChild {
  username: string
  firstName: string
  lastName: string
  email: string
}

export interface User {
  username: string
  firstName: string
  lastName: string
  isAdmin: boolean
  isBoss: boolean
  children: UserChild[]
}
