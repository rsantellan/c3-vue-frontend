export interface UserProfile {
  username: string
  email: string
  firstName: string
  lastName: string
  group: string
  startingDate: string
  lastVisit: string
  state: string
}

export interface UpdateProfilePayload {
  firstName: string
  lastName: string
  email: string
}

export interface ChangePasswordPayload {
  currentPassword: string
  newPassword: string
}
