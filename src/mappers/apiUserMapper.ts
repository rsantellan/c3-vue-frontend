import { User, AdminClient, ApiUser, AdminClientApi } from '@/types/user'

export function mapApiUser(apiUser: ApiUser): User {
  return {
    id: Number(apiUser.id),
    username: apiUser.username,
    email: apiUser.email,
    firstName: apiUser.first_name,
    lastName: apiUser.last_name,
    lastVisit: apiUser.lastvisit_at,
    isAdmin: apiUser.superuser === '1',
  }
}

export function mapAdminClient(apiClient: AdminClientApi): AdminClient {
  return {
    id: apiClient.id,
    socialReason: apiClient.social_reason,
    folder: apiClient.folder_number,
    groupId: apiClient.groupId,
    groupName: apiClient.groupName,
    groupCode: apiClient.groupCode,
  }
}
