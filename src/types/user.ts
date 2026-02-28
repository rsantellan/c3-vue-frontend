export interface ApiUser {
  id: string
  username: string
  email: string
  status: string
  superuser: string
  group_id: string
  group_boss: string
  client_id: number | null
  create_at: string
  lastvisit_at: string | null
  first_name: string
  last_name: string
}

export interface UsersResponse {
  message: string
  data: {
    users: ApiUser[]
    quantity: string
  }
}

export interface UsersRequest {
  page: number
  limit: number
  search?: string
}

export interface User {
  id: number
  username: string
  email: string
  firstName: string
  lastName: string
  lastVisit: string | null
  isAdmin: boolean
}

export interface UserForm {
  firstName: string
  lastName: string
  email: string
  username: string
}

export interface AdminUserForm {
  username: string
  email: string
  status: number
  password: string
  group_id: string | number
  client_id: string | number
  firstName: string
  lastName: string
}

export interface AdminGroup {
  id: number
  name: string
  code: string
}

export interface AdminClientApi {
  id: number
  social_reason: string
}

export interface AdminClient {
  id: number
  socialReason: string
}
