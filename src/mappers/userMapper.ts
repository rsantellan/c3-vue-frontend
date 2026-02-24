import type { ApiUser, User } from '@/types/auth'

export function mapUser(apiUser: ApiUser): User {
  return {
    username: apiUser.username,
    firstName: apiUser.firstName,
    lastName: apiUser.lastName,

    isAdmin: apiUser.superuser === '1',

    children: (apiUser.children || []).map((c) => ({
      username: c.username,
      firstName: c.first_name,
      lastName: c.last_name,
      email: c.email,
    })),

    isBoss: !!apiUser.children?.length,
  }
}
