export interface ClientPermissions {
  monthAmount: boolean
  currentAccountData: boolean
  files: boolean
  certificates: boolean
}

export interface Client {
  id: number
  folderNumber: string
  socialReason: string
  permissions: ClientPermissions
}

export interface ClientResponse {
  success: boolean
  username: string
  clients: Client[]
}
