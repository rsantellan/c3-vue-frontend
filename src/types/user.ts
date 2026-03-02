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
  id: string
  social_reason: string
  folder_number: string
  groupId?: number
  groupName?: string
  groupCode?: string
}

export interface AdminClient {
  id: string
  socialReason: string
  folder: string
  groupId?: number
  groupName?: string
  groupCode?: string
}

export interface AdminPermissionType {
  name: string
  description: string
}

export interface UserPermissionResponse {
  success: boolean
  message: string
  data: UserPermission[]
}

export interface UserPermission {
  type: string
  data: UserPermissionClient[]
}

export interface UserPermissionClient {
  id: number
  folder: string
}

export interface UserPermissionApiResponse {
  data: UserWithPermissions[]
  pagination: {
    page: number
    perPage: number
    total: number
  }
}

export interface UserPermissionSummary {
  type: string
  name: string
  description: string
}

export interface UserWithPermissions {
  id: number
  username: string
  permissions: UserPermissionSummary[]
}

export interface UserPermissionApiRequest {
  page: number
  perPage: number
  search: string
}
