import type { Client } from '@/types/client'

export function mapClient(apiClient: any): Client {
  return {
    id: apiClient.id,
    folderNumber: apiClient.folder_number,
    socialReason: apiClient.social_reason,

    permissions: {
      monthAmount: apiClient.permissions['month-amount'],
      currentAccountData: apiClient.permissions['current-account-data'],
      files: apiClient.permissions.files,
      certificates: apiClient.permissions.certificates,
    },
  }
}
